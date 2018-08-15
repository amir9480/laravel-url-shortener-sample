<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>کوتاه کننده لینک</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-offset-3 col-xs-6">
                <h2 class="text-right">کوتاه کننده لینک</h2>
                <form>
                    <input type="url" name="url" class="form-control" placeholder="لینک آدرس" required autofocus>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="button">کوتاه کن</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

    <script>
        $(function(){
            $("form button").click(function(){
                var button = $(this);
                $(button).prop('disabled', true);//  دکمه رو تا زمان دریافت نتیجه غیرفعال میشه
                $("form .alert").remove();
                $.ajax({
                    url: @json(route("request_link")),
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': @json(csrf_token())
                    },
                    data: $("form").serialize(),
                    success: function(response) {
                        //  اسلاگ رو نمایش میدیم
                        $("form").prepend(`<div class="alert alert-success">
                            ${response.slug}
                        </div>`);
                        $(button).prop('disabled', false); // دکمه رو فعال میشه
                    },
                    error: function(xhr, status, errorThrown) {
                        //  ورودی مشکل داره پس ارور ها رو نشون میدیم
                        var urlErrors = xhr.responseJSON.errors.url;
                        for(var i in urlErrors) {
                            $("form").prepend(`<div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                ${urlErrors[i]}
                            </div>`);
                        }
                        $(button).prop('disabled', false); // دکمه رو فعال میشه
                    }
                });
            });
        });
    </script>
</body>

</html>
