<html>
    <body>
    {title}

<table>
    <tr>
        <td>First Name</td>
        <td>Last Name</td>
    </tr>
<? foreach($names as $n): ?>
    <tr bgcolor="<?= $this->cycle("#cccccc,#fefefe,#666666")?>">
        <td><?= htmlentities($n['first'])?></td>
        <td><?= $n['last']?></td>
    </tr>
<? endforeach?>
</table>
    </body>
</html>
