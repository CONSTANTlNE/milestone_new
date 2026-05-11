<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #e8e8e8; font-family: Arial, Helvetica, sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #e8e8e8;">
    <tr>
        <td align="center" style="padding: 30px 20px;">

            <!-- Card: 580px wide -->
            <table role="presentation" width="580" cellpadding="0" cellspacing="0" border="0">

                <!-- ── HEADER ── -->
                <tr>
                    <td align="center" style="background-color: #0a0f15; border-radius: 24px; padding: 36px 20px 32px;">
                        <img src="{{ asset('assets/email/logo.png') }}" alt="Milestone Brokers" width="64" height="39" style="display: block; border: 0; width: 64px; height: 39px; margin-bottom: 8px;" />
                        <p style="margin: 0 0 4px; font-size: 30px; font-weight: bold; color: #ffffff; text-align: center; font-family: Arial, Helvetica, sans-serif;">Milestone Brokers</p>
                        <p style="margin: 0; font-size: 17px; color: #cccccc; text-align: center; line-height: 25px; font-family: Arial, Helvetica, sans-serif;">Thank you for your inquiry</p>
                    </td>
                </tr>

                <!-- spacer -->
                <tr><td height="10" style="font-size: 0; line-height: 0; mso-line-height-rule: exactly;">&nbsp;</td></tr>

                <!-- ── BODY WRAPPER ── -->
                <tr>
                    <td style="background-color: #f5f5f5; border-radius: 24px; padding: 10px;">

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">

                            <!-- ── ICONS HEADER ROW ── -->
                            <tr>
                                <td style="background-color: #ffffff; border-radius: 24px; padding: 20px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>

                                            <td style="text-align: center; vertical-align: middle; padding-right: 8px;">
                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tr>
                                                        <td width="50" height="50" style="width: 50px; height: 50px; border-radius: 50px; background-color: #003285; text-align: center; vertical-align: middle;">
                                                            <img src="{{ asset('assets/email/start.png') }}" alt="Start" width="24" height="24" style="display: block; margin: 13px; border: 0;" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td style="text-align: center; vertical-align: middle; padding-right: 8px;">
                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tr>
                                                        <td width="50" height="50" style="width: 50px; height: 50px; border-radius: 50px; background-color: #003285; text-align: center; vertical-align: middle;">
                                                            <img src="{{ asset('assets/email/destination.png') }}" alt="Destination" width="24" height="24" style="display: block; margin: 13px; border: 0;" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td style="text-align: center; vertical-align: middle; padding-right: 8px;">
                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tr>
                                                        <td width="50" height="50" style="width: 50px; height: 50px; border-radius: 50px; background-color: #003285; text-align: center; vertical-align: middle;">
                                                            <img src="{{ asset('assets/email/car.png') }}" alt="Car" width="24" height="24" style="display: block; margin: 13px; border: 0;" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tr>
                                                        <td width="50" height="50" style="width: 50px; height: 50px; border-radius: 50px; background-color: #003285; text-align: center; vertical-align: middle;">
                                                            <img src="{{ asset('assets/email/price.png') }}" alt="Price" width="24" height="24" style="display: block; margin: 13px; border: 0;" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- ── QUOTATION ROWS ── -->
                            @foreach($quotations as $quotation)
                            <!-- spacer -->
                            <tr><td height="4" style="font-size: 0; line-height: 0; mso-line-height-rule: exactly;">&nbsp;</td></tr>
                            <tr>
                                <td style="background-color: #ffffff; border-radius: 24px; padding: 14px 20px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle; padding-right: 8px; font-size: 14px; color: #334060; line-height: 22px; font-family: Arial, Helvetica, sans-serif;">{{ $quotation->start_address }}</td>
                                            <td style="text-align: center; vertical-align: middle; padding-right: 8px; font-size: 14px; color: #334060; line-height: 22px; font-family: Arial, Helvetica, sans-serif;">{{ $quotation->destination_address }}</td>
                                            <td style="text-align: center; vertical-align: middle; padding-right: 8px; font-size: 14px; color: #334060; line-height: 22px; font-family: Arial, Helvetica, sans-serif;">{{ $quotation->vehicle }}</td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px; color: #334060; line-height: 22px; font-family: Arial, Helvetica, sans-serif;">{{ round($quotation->calculated_cost) }}$</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endforeach

                            <!-- spacer -->
                            <tr><td height="4" style="font-size: 0; line-height: 0; mso-line-height-rule: exactly;">&nbsp;</td></tr>

                            <!-- ── STEPS CARD ── -->
                            <tr>
                                <td style="background-color: #ffffff; border-radius: 20px; padding: 20px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">

                                        <!-- Step 1 -->
                                        <tr>
                                            <td style="padding: 10px 0;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td width="32" style="vertical-align: top; padding-top: 4px;">
                                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="32" height="32" style="width: 32px; height: 32px; background-color: #e6edf8; border-radius: 32px; text-align: center; vertical-align: middle; font-size: 16px; font-weight: bold; color: #003285; font-family: Arial, Helvetica, sans-serif; line-height: 32px;">1</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding-left: 12px; padding-top: 4px; vertical-align: top; font-size: 18px; color: #000d24; line-height: 24px; font-family: Arial, Helvetica, sans-serif;">Thank you for choosing Milestone Brokers. Your transport request has been successfully received.</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr><td height="1" bgcolor="#e8e8e8" style="font-size: 0; line-height: 0;">&nbsp;</td></tr>

                                        <!-- Step 2 -->
                                        <tr>
                                            <td style="padding: 10px 0;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td width="32" style="vertical-align: top; padding-top: 4px;">
                                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="32" height="32" style="width: 32px; height: 32px; background-color: #e6edf8; border-radius: 32px; text-align: center; vertical-align: middle; font-size: 16px; font-weight: bold; color: #003285; font-family: Arial, Helvetica, sans-serif; line-height: 32px;">2</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding-left: 12px; padding-top: 4px; vertical-align: top; font-size: 18px; color: #000d24; line-height: 24px; font-family: Arial, Helvetica, sans-serif;">Our team is now reviewing your route, vehicle details, and carrier availability to prepare the next steps.</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr><td height="1" bgcolor="#e8e8e8" style="font-size: 0; line-height: 0;">&nbsp;</td></tr>

                                        <!-- Step 3 -->
                                        <tr>
                                            <td style="padding: 10px 0;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td width="32" style="vertical-align: top; padding-top: 4px;">
                                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="32" height="32" style="width: 32px; height: 32px; background-color: #e6edf8; border-radius: 32px; text-align: center; vertical-align: middle; font-size: 16px; font-weight: bold; color: #003285; font-family: Arial, Helvetica, sans-serif; line-height: 32px;">3</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding-left: 12px; padding-top: 4px; vertical-align: top; font-size: 18px; color: #000d24; line-height: 24px; font-family: Arial, Helvetica, sans-serif;">A logistics coordinator will contact you shortly to confirm scheduling, pricing, and pickup instructions.</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr><td height="1" bgcolor="#e8e8e8" style="font-size: 0; line-height: 0;">&nbsp;</td></tr>

                                        <!-- Step 4 -->
                                        <tr>
                                            <td style="padding: 10px 0;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td width="32" style="vertical-align: top; padding-top: 4px;">
                                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="32" height="32" style="width: 32px; height: 32px; background-color: #e6edf8; border-radius: 32px; text-align: center; vertical-align: middle; font-size: 16px; font-weight: bold; color: #003285; font-family: Arial, Helvetica, sans-serif; line-height: 32px;">4</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding-left: 12px; padding-top: 4px; vertical-align: top; font-size: 18px; color: #000d24; line-height: 24px; font-family: Arial, Helvetica, sans-serif;">After confirmation, you will receive shipment updates and dispatch support throughout the transport process.</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            <!-- spacer -->
                            <tr><td height="4" style="font-size: 0; line-height: 0; mso-line-height-rule: exactly;">&nbsp;</td></tr>

                            <!-- ── CTA BUTTON ── -->
                            <tr>
                                <td align="center" style="background-color: #003285; border-radius: 100px;">
                                    <a href="{{$signed_url}}" style="display: block; padding: 14px 30px; font-size: 18px; font-weight: bold; color: #ffffff; text-decoration: none; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 22px; white-space: nowrap;">Confirm Request</a>
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
