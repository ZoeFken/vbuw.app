<html>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
				<h1><?php echo sprintf(lang('email_person_title'), $identity);?></h1>
				<img src="<?php echo base_url('assets/images/email.png') ?>" alt="logo"><br><br>
				<p><?php echo lang('email_subtext_one') ?></p>
				<a href="<?php echo base_url('auth/reset_password/'. $forgotten_password_code) ?>" style="background-color:#303030;border:1px solid #375a7f;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:250px;-webkit-text-size-adjust:none;mso-hide:all;"><?php echo lang('email_forgot_password_link') ?></a>
				<p><?php echo lang('email_subtext_two') ?></p>
				<p><?php echo base_url('auth/reset_password/'. $forgotten_password_code) ?></p>
			</td>
        </tr>
    </table>
</body>
</html>
