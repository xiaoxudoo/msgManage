<?php

namespace App\Http\Controllers\Captcha;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    /**
     * 生成验证码.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $captcha = new CaptchaBuilder;

        //设置图片宽高和字体
        $captcha->build($width = 160, $height = 40, $font = null);

        //获取验证码的内容
        $phrase = $captcha -> getPhrase();
        //把内容存入session
        Session::forget('u_captcha');
        Session::put('u_captcha', $phrase);

        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $captcha->output();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
