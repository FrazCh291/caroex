{{--@extends('beautymail::templates.ark')--}}

{{--@section('content')--}}

{{--    @include('beautymail::templates.ark.contentStart')--}}

<html>
<head>
    <style>
        /* -------------------------------------
            GLOBAL RESETS
        ------------------------------------- */

        /*All the styling goes here*/
        body {
            background-color: #ffffff;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%; }
        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */

        .body {
            /*background-color: #f6f6f6;*/
            width: 100%;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 580px;
            padding: 10px;
            width: 580px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 20px;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize;
        }

        p,
        ul,
        ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }
        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #3498db;
            text-decoration: underline;
        }

        /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%; }
        .btn > tbody > tr > td {
            padding-bottom: 25px; }
        .btn table {
            width: auto;
        }
        .btn table td {
            background-color: #ffffff;
        }

        .btn-primary table td {
            /*background-color: #3498db;*/
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0;
        }

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }
            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }
            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }
            table[class=body] .content {
                padding: 0 !important;
            }
            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }
            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }
            table[class=body] .btn table {
                width: 100% !important;
            }
            table[class=body] .btn a {
                /*width: 100% !important;*/
            }
            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
            /*.apple-link a {*/
            /*    color: inherit !important;*/
            /*    font-family: inherit !important;*/
            /*    font-size: inherit !important;*/
            /*    font-weight: inherit !important;*/
            /*    line-height: inherit !important;*/
            /*    text-decoration: none !important;*/
            /*}*/
            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }
        }

    </style>
</head>
<body class="">
<table role="" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
                <table role="" class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <table role="" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table role="" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                            <tbody>
                                            <tr>
                                                <td align="left">
                                                    <table role="" border="0" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                        <tr>
                                                            Hello, {{ Session::get('customer')}}
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Thank you for placing an order with us. Our delivery team has generated a delivery label. Your goods will be
                                                                picked and collected shortly. For further any inquiries please contact at:

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                {{ Session::get('delivery_email')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                <span style="font-weight:bold"> Order summary</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Order Item: {{ Session::get('product')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Courier: Tuffnells
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Ship by Date: {{ Session::get('collectDate1')}} to {{ Session::get('collectDate2')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Delivery by Date: {{ Session::get('estimatedDate1')}} to {{ Session::get('estimatedDate2')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Delivery Time: 8am to 6pm
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">

                                                                Tracking No: <span style="font-weight:bold">{{ Session::get('tracking_number')}}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Track parcel: https://www.tuffnells.co.uk/track-and-trace
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                You can use the parcel tracking system after 7 pm on the day of collection. Once the courier collects your
                                                                parcel, it is in their safe hands. They have 99% delivery-on-time success rates, but if there is a delay or
                                                                your parcel was not received on time, let us know promptly so we can assist you by getting in touch with the
                                                                couriers.
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                <span style="font-weight:bold">Keep the packaging:</span> please do not dispose of the original packing.
                                                                Once your item arrives, please keep all
                                                                of the outer and inner packaging just in case you decide you don’t want to keep the item, returns are not
                                                                accepted without original packaging.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                <span style="font-weight:bold">Return options:</span> The carriage cost for us to collect the item is 40
                                                                GBP. Alternatively, you can have the item
                                                                sent back to us yourself.
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                We are a small family business, so keeping things running smoothly and maintaining a positive feedback
                                                                result is super important to us. We therefore ask, should you have any issues related to the delivery, the
                                                                order process or the actual item itself, please get in touch with us, we are here to help every step of the
                                                                way. We are just a message away.
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                Delivery Team
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px">
                                                                <span style="font-weight:bold">{{ Session::get('channel')}}</span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- END MAIN CONTENT AREA -->
                </table>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>


















{{--  <table class="container">--}}
{{--      <tbody>--}}
{{--      <tr>--}}
{{--          <td class="title" style="padding-bottom: 15px; padding-top: 15px">--}}
{{--              Hello, {{ Session::get('customer')}}--}}

{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="10" style="padding-bottom: 15px">--}}
{{--              Thank you for placing an order with us. Our delivery team has generated a delivery label. Your goods will be--}}
{{--              picked and collected shortly. For further any inquiries please contact at:--}}

{{--          </td>--}}
{{--      </tr>--}}

{{--      <tr>--}}
{{--          <td class="paragraph" style="padding-bottom: 5px">--}}
{{--              {{ Session::get('delivery_email')}}--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 5px">--}}
{{--              <span style="font-weight:bold"> Order summary</span>--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 5px">--}}
{{--              Order Item: {{ Session::get('product')}}--}}
{{--          </td>--}}
{{--      </tr>--}}

{{--      <tr>--}}
{{--          <td width="100%" height="10" style="padding-bottom: 5px">--}}
{{--              Courier: Tuffnells--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td class="paragraph" style="padding-bottom: 5px">--}}
{{--              Ship by Date: {{ Session::get('collectDate1')}} to {{ Session::get('collectDate2')}}--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 5px">--}}
{{--              Delivery by Date: {{ Session::get('estimatedDate1')}} to {{ Session::get('estimatedDate2')}}--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 5px">--}}
{{--              Delivery Time: 8am to 6pm--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 5px">--}}


{{--              Tracking No: <span style="font-weight:bold">{{ Session::get('tracking_number')}}</span>--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 5px">--}}
{{--              Track parcel: https://www.tuffnells.co.uk/track-and-trace--}}
{{--          </td>--}}
{{--      </tr>--}}

{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 15px">--}}
{{--              You can use the parcel tracking system after 7 pm on the day of collection. Once the courier collects your--}}
{{--              parcel, it is in their safe hands. They have 99% delivery-on-time success rates, but if there is a delay or--}}
{{--              your parcel was not received on time, let us know promptly so we can assist you by getting in touch with the--}}
{{--              couriers.--}}
{{--          </td>--}}
{{--      </tr>--}}

{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 15px">--}}
{{--              <span style="font-weight:bold">Keep the packaging:</span> please do not dispose of the original packing.--}}
{{--              Once your item arrives, please keep all--}}
{{--              of the outer and inner packaging just in case you decide you don’t want to keep the item, returns are not--}}
{{--              accepted without original packaging.--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 15px">--}}

{{--              <span style="font-weight:bold">Return options:</span> The carriage cost for us to collect the item is 40--}}
{{--              GBP. Alternatively, you can have the item--}}
{{--              sent back to us yourself.--}}
{{--          </td>--}}
{{--      </tr>--}}

{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 15px">--}}
{{--              We are a small family business, so keeping things running smoothly and maintaining a positive feedback--}}
{{--              result is super important to us. We therefore ask, should you have any issues related to the delivery, the--}}
{{--              order process or the actual item itself, please get in touch with us, we are here to help every step of the--}}
{{--              way. We are just a message away.--}}
{{--          </td>--}}
{{--      </tr>--}}

{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 1px">--}}
{{--              Delivery Team--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      <tr>--}}
{{--          <td width="100%" height="25" style="padding-bottom: 15px">--}}
{{--              <span style="font-weight:bold">{{ Session::get('channel')}}</span>--}}
{{--          </td>--}}
{{--      </tr>--}}
{{--      </tbody>--}}
{{--  </table>--}}
{{--    @include('beautymail::templates.ark.contentEnd')--}}
