<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;

class LinkController extends Controller
{
    public function show(Request $request)
    {
        return view('home');
    }

    public function requestLink(Request $request)
    {
        // اول ولیدیشن رو انجام میدم
        $this->validate($request, [ 
            'url' => 'required|url'
        ]);
        // اگه لینک از قبل وجود داشت میگیرم یا یه دونه جدیدش رو میسازم
        $link = Link::where('url', $request->input('url'))->firstOrCreate([
            'url' => $request->input('url')
        ]);
        // مقدار اسلاگ رو بر اساس آیدی تنظیم میکنم مهم نیست از قبل ساخته شده بوده یا نه چون نتیجه بر اساس آی دی هست همیشه همون مقداره
        $link->slug = $this->generateSlug($link->id);
        // سیو میکنم
        $link->save();
        return [ 
            'slug' => route("open_link", ['slug' => $link->slug])
        ];
    }

    public function openLink($slug)
    {
        return redirect()->to(Link::where('slug', $slug)->firstOrFail()->url);
    }

    protected function generateSlug($id)
    {
        $id-=1; // چون آی دی ها از یک شروع میشن و رشته ها از صفر یه دونه ازش کم میکنم
        $alpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789-_";
        $alphaLen = strlen($alpha);
        $out = "";
        while($id > 0) { // تبدیل مبنا از عدد به مبنای من در آوردی
            $out.= $alpha[$id%$alphaLen]; // یه دونه از کاراکتر ها رو میگیرم
            $id = intval($id/$alphaLen); // آی دی رو تقسیم میکنم برای گرفتن المنت بعدی
        }
        return $out;
    }
}
