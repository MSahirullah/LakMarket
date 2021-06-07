<body>
    <table style="        width: 100%;
    margin: 0;
    padding: 0;
    background-color: #f5f7f9;" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table style="        width: 100%;
                margin: 0;
                padding: 0;" width="100%" cellpadding="0" cellspacing="0">
                    <!-- Logo -->
                    <tr>
                        <td style="        padding: 25px 0;
        text-align: center;">
                            <a style="        font-size: 16px;
        font-weight: bold;
        color: #839197;
        text-decoration: none;
        text-shadow: 0 1px 0 white;">Lak Market</a>
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td style="        width: 100%;
                        margin: 0;
                        padding: 0;
                        border-top: 1px solid #e7eaec;
                        border-bottom: 1px solid #e7eaec;
                        background-color: #ffffff;" width="100%">
                            <table style="        width: 570px;
                            margin: 0 auto;
                            padding: 0;" align="center" width="570" cellpadding="0" cellspacing="0">
                                <!-- Body content -->
                                <tr>
                                    <td style=" padding: 35px;">
                                        <b>
                                            <p stye="        margin-top: 0;
                                            color: #292e31;
        font-size: 16px;
        line-height: 1.5em;
        text-align: left;">
                                                Password Reset
                                            </p>
                                        </b>
                                        <p stye="margin-top: 0;
        color: #839197;
        font-size: 16px;
        line-height: 1.5em;
        text-align: left;">
                                            If you have lost your password or wish to reset it, use the link below to get started.
                                        </p>
                                        <!-- Action -->
                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    <div>
                                                        <a href="http://127.0.0.1:8000/password-reset?token={{$email_data['resetLink']}}" style="display: inline-block;
        width: 200px;
        background-color: #414ef9;
        border-radius: 3px;
        color: #ffffff;
        font-size: 15px;
        margin-top:0px;
        line-height: 45px;
        text-align: center;
        text-decoration: none;
        -webkit-text-size-adjust: none;
        mso-hide: all;
        background-color: #414ef9;
        border-radius: 40px;">Reset Password</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <p>If you did not request a password reset, you can safely ignore this email. Only a person with access to your email can reset your account password. <br /><br />The Lak Market Team</p>
                                        <!-- Sub copy -->
                                        <table class="body-sub">
                                            <tr>
                                                <td>
                                                    <p stye="margin-top: 0;
        color: #839197;
        font-size: 16px;
        line-height: 1.5em;
        text-align: left;
        font-size:12px" class="sub">
                                                        If you’re having trouble clicking the button, copy
                                                        and paste the URL below into your web browser.
                                                    </p>
                                                    <p stye="margin-top: 0;
        color: #839197;
        font-size: 16px;
        line-height: 1.5em;
        text-align: left;
        font-size:12px;" class="sub">
                                                        <a href="http://127.0.0.1:8000/password-reset?token={{$email_data['resetLink']}}">http://127.0.0.1:8000/password-reset</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <div style="background-color: #e6e7ff;">
                                                    <p style="padding: 15px 15px 0px 10px;
                            text-align: center;
                            color: black;">Need More Help?</p>
                                                    <a href="{{route('customer-care')}}" style="text-decoration: none;">
                                                        <p style="padding: 0px 15px 15px 15px;
                            text-align: center;    margin-top: 0px;text-decoration: underline;">Contact Us</p>
                                                    </a>
                                                </div>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <table style="        width: 570px;
                            margin: 0 auto;
                            padding: 0;
                            text-align: center;" align="center" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style=" padding: 35px;">
                                        <p stye="margin-top: 0;
                                        color: #839197;
        font-size: 16px;
        line-height: 1.5em;
        text-align: left;
        font-size:12px">
                                            Lak Market
                                            <br />Department of Information Communications
                                            Technology <br />Faculty of Technology, University of
                                            Colombo.
                                        </p>
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