<?php
$fontreset   = "font-family: Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em;";
$marginreset = "margin: 0; padding: 0;";
$paraeset = "font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;";
?>

<!DOCTYPE html>
<html style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; {{ $marginreset }}">
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Inscription à la newsletter</title>
</head>
<body bgcolor="#f6f6f6" style="{{ $fontreset }} -webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; {{ $marginreset }}">

<!-- body -->
<table class="body-wrap" bgcolor="#f6f6f6" style="{{ $fontreset }} width: 100%; margin: 0; padding: 20px;">
    <tr style="{{ $fontreset }} {{ $marginreset }}">
        <td style="{{ $fontreset }} {{ $marginreset }}"></td>
        <td class="container" bgcolor="#FFFFFF" style="{{ $fontreset }} clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

            <!-- content -->
            <div class="content" style="{{ $fontreset }} display: block; max-width: 600px; margin: 0 auto; padding: 0;">
                <table style="{{ $fontreset }}  width: 100%; {{ $marginreset }}">
                    <tr style="{{ $fontreset }} {{ $marginreset }}">
                        <td style="{{ $fontreset }} {{ $marginreset }}" width="40">
                            <img style="max-width: 100%; width: 90%;" src="{{ asset('files/logos/facdroit.png') }}" alt="{{ $site->url }}">
                        </td>
                        <td style="{{ $fontreset }} {{ $marginreset }}" width="10"></td>
                        <td style="{{ $fontreset }} {{ $marginreset }}" width="50">
                            <h1 style="{{ $fontreset }} font-size: 24px; line-height: 1.2em; color: #111111; font-weight: 500; margin: 20px 0 10px; padding: 0;">
                               Confirmation depuis <br/><small style=" font-size: 20px; color: #1c4d79;">{{ $site->nom }}</small>
                            </h1>
                        </td>
                    </tr>
                    <tr style="{{ $fontreset }} {{ $marginreset }}">
                        <td colspan="3" style="{{ $fontreset }} {{ $marginreset }} height:20px;"></td>
                    </tr>
                    <tr style="{{ $fontreset }} {{ $marginreset }}">
                        <td colspan="3" style="{{ $fontreset }} {{ $marginreset }}">

                            <div style="font-family: arial, sans-serif;">Pour confirmer votre inscription sur {{ $site->nom }} veuillez suivre ce lien:
                                <p style="font-family: arial, sans-serif;">
                                    <a style="text-align:center;font-size:13px;font-family:arial,sans-serif;
                color:white;font-weight:bold;background-color: #1c1c84;border: 1px solid #1c1c84;
                text-decoration:none;display:inline-block;min-height:27px;padding-left:8px;padding-right:8px;
                line-height:27px;border-radius:2px;border-width:1px" href="{{ url('activation/'.$token) }}">Confirmer l'adresse email</a>
                                </p>
                            </div>

                        </td>
                    </tr>
                    <tr style="{{ $fontreset }} {{ $marginreset }}">
                        <td colspan="3" style="{{ $fontreset }} {{ $marginreset }} height:10px; border-bottom: 1px solid #e2e2e2;"></td>
                    </tr>
                    <tr style="{{ $fontreset }} {{ $marginreset }}">
                        <td colspan="3" style="{{ $fontreset }} {{ $marginreset }} height:10px;"></td>
                    </tr>
                    <tr style="{{ $fontreset }} {{ $marginreset }}">
                        <td colspan="3" style="{{ $fontreset }} {{ $marginreset }}">
                            <p style="{{ $fontreset }} {{ $paraeset }}"><a href="{{ url($site->url) }}">{{ $site->url }}</a></p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->

        </td>
        <td style="{{ $fontreset }} {{ $marginreset }}"></td>
    </tr>
</table>
<!-- /body -->
<!-- footer -->
<table class="footer-wrap" style="{{ $fontreset }} clear: both !important; width: 100%; {{ $marginreset }}"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; {{ $marginreset }}">
        <td style="{{ $fontreset }} {{ $marginreset }}"></td>
        <td class="container" style="{{ $fontreset }} clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 0;">
            <!-- content -->
            <div class="content" style="{{ $fontreset }} display: block; max-width: 600px; margin: 0 auto; padding: 0;">
                <table style="{{ $fontreset }} width: 100%; {{ $marginreset }}"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; {{ $marginreset }}">
                        <td align="center" style="{{ $fontreset }} {{ $marginreset }}">
                            <p style="{{ $fontreset }} font-size: 12px; color: #666666; font-weight: normal; margin: 0 0 10px; padding: 0;">
                                &copy; {{ $site->nom }}  {{ date('Y') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->
        </td>
        <td style="{{ $fontreset }} {{ $marginreset }}"></td>
    </tr>
</table>
<!-- /footer -->
</body>
</html>
