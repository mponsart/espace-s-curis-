<table cellpadding="0" cellspacing="0" border="0" style="font-family: 'Titillium Web', Arial, sans-serif; font-size: 13px; color: #333; max-width: 300px;">
  <tr>
    <td style="padding-bottom: 6px;">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td style="vertical-align: middle; padding-right: 10px;">
            <img src="<?= $company['logo'] ?>" alt="" width="40" height="40" style="display: block; border-radius: 8px;">
          </td>
          <td style="vertical-align: middle;">
            <span style="font-size: 14px; font-weight: 700; color: #1a1a1a; display: block;"><?= $name ?></span>
            <?php if ($job): ?>
            <span style="font-size: 11px; color: #8a4dfd; font-weight: 600;"><?= $job ?></span>
            <?php endif; ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #e5e5e5; padding-top: 6px; font-size: 11px; color: #666;">
      <a href="mailto:<?= $email ?>" style="color: #666; text-decoration: none;"><?= $email ?></a><br>
      <a href="<?= $company['website'] ?>" style="color: #8a4dfd; text-decoration: none; font-weight: 600;"><?= $company['domain'] ?></a>
    </td>
  </tr>
</table>
