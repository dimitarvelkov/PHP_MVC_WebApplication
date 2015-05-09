<table>
    <tr>
        <td>id</td>
        <td>name</td>
    </tr>
<?php foreach($this->authors as $author ):?>
    <tr>
        <td>"<?= htmlspecialchars($author["id"]) ?>"</td>
        <td>"<?=htmlspecialchars($author["name"])?>"</td>
        <td><a href="/authors/delete/<?=$author["id"]?>">[delete]</a></td>
        <td>"<?=htmlspecialchars($author["name"])?>"</td>
    </tr>
<?php endforeach ?>
</table>

<a href="/authors/create">new author</a>