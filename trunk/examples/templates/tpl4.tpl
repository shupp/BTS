<html>
    <body>
    {title}

<table>
    <tr>
        <td bgcolor="<?= $this->cycle("#eeeeee,#dddddd") ?>">Select Name</td>
        <td><select name=names><?= $this->selectOptions($names, $name_selected)?></select></td>
        <td bgcolor="<?= $this->cycle("#eeeeee,#dddddd") ?>">Select Name</td>
        <td><select name=names><?= $this->selectOptions($names, $name_selected)?></select></td>
    </tr>
</table>
    </body>
</html>
