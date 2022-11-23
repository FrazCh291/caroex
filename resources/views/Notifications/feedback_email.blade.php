<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:text-align="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
<style>
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0"
       style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0"
                   style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td class="header"
                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
                        <a href="{{url('https://xstreamgym.com')}}"
                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                            <h1>Xstream Gym</h1>
                        </a>
                    </td>
                </tr>
                <!-- Email Body -->
                <tr>
                    @if($customer !== null && $order !== null)
                        <td class="body" width="100%" cellpadding="0" cellspacing="0"
                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                   style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell"
                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                        <h2>Dear {{$customer->name}},</h2>
                                        <p>Thanks for your order from xstream gym. Please rate our services how much you
                                            liked our servcies.</p>
                                        <button type="button">
                                            <a href="{{url('/rating',['rating'=>'1','order_id'=>$order->id])}}"
                                               class="button button-primary" target="_blank"
                                               style="font-family: Avenir, Helvetica,
                                                                            sans-serif; box-sizing: border-box;
                                                                            border-radius: 3px; box-shadow: 0 2px 3px
                                                                            rgba(0, 0, 0, 0.16); color: #FFF; display:
                                                                            inline-block; text-decoration: none;
                                                                            -webkit-text-size-adjust: none;
                                                                            background-color: #3097D1; border-top: 10px
                                                                            solid #3097D1; border-right: 18px solid
                                                                            #3097D1; border-bottom: 10px solid #3097D1;
                                                                            border-left: 18px solid #3097D1;">Poor</a>
                                        </button>
                                        <button type="button">
                                            <a href="{{url('/rating',['rating'=>'2','order_id'=>$order->id])}}"
                                               class="button button-primary" target="_blank"
                                               style="font-family: Avenir, Helvetica,
                                                                            sans-serif; box-sizing: border-box;
                                                                            border-radius: 3px; box-shadow: 0 2px 3px
                                                                            rgba(0, 0, 0, 0.16); color: #FFF; display:
                                                                            inline-block; text-decoration: none;
                                                                            -webkit-text-size-adjust: none;
                                                                            background-color: #3097D1; border-top: 10px
                                                                            solid #3097D1; border-right: 18px solid
                                                                            #3097D1; border-bottom: 10px solid #3097D1;
                                                                            border-left: 18px solid #3097D1;">Average</a>
                                        </button>
                                        <button type="button">
                                            <a href="{{url('/rating',['rating'=>'3','order_id'=>$order->id])}}"
                                               class="button button-primary" target="_blank"
                                               style="font-family: Avenir, Helvetica,
                                                                            sans-serif; box-sizing: border-box;
                                                                            border-radius: 3px; box-shadow: 0 2px 3px
                                                                            rgba(0, 0, 0, 0.16); color: #FFF; display:
                                                                            inline-block; text-decoration: none;
                                                                            -webkit-text-size-adjust: none;
                                                                            background-color: #3097D1; border-top: 10px
                                                                            solid #3097D1; border-right: 18px solid
                                                                            #3097D1; border-bottom: 10px solid #3097D1;
                                                                            border-left: 18px solid #3097D1;">Good</a>
                                        </button>
                                        <button type="button">
                                            <a href="{{url('/rating',['rating'=>'4','order_id'=>$order->id])}}"
                                               class="button button-primary" target="_blank"
                                               style="font-family: Avenir, Helvetica,
                                                                            sans-serif; box-sizing: border-box;
                                                                            border-radius: 3px; box-shadow: 0 2px 3px
                                                                            rgba(0, 0, 0, 0.16); color: #FFF; display:
                                                                            inline-block; text-decoration: none;
                                                                            -webkit-text-size-adjust: none;
                                                                            background-color: #3097D1; border-top: 10px
                                                                            solid #3097D1; border-right: 18px solid
                                                                            #3097D1; border-bottom: 10px solid #3097D1;
                                                                            border-left: 18px solid #3097D1;">Excellent</a>
                                        </button>
                                        <p>To stop email notification click here:</p>
                                        <p>
                                            {{--<a href="{{url('/setting')}}" class="button button-primary" target="_blank"--}}
                                            {{--style="font-family: Avenir, Helvetica,--}}
                                            {{--sans-serif; box-sizing: border-box;--}}
                                            {{--border-radius: 3px; box-shadow: 0 2px 3px--}}
                                            {{--rgba(0, 0, 0, 0.16); color: #FFF; display:--}}
                                            {{--inline-block; text-decoration: none;--}}
                                            {{---webkit-text-size-adjust: none;--}}
                                            {{--background-color: #3097D1; border-top: 10px--}}
                                            {{--solid #3097D1; border-right: 18px solid--}}
                                            {{--#3097D1; border-bottom: 10px solid #3097D1;--}}
                                            {{--border-left: 18px solid #3097D1;">Stop--}}
                                            {{--emails</a>--}}
                                        </p>
                                        <p>regards</p>
                                        <p><em>Xsream Gym</em></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table class="footer" align="center" width="570"
                               cellpadding="0" cellspacing="0"
                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                            <tr>
                                <td class="content-cell" align="center"
                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">
                                        © Xstream Gym</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>