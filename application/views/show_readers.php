
<table>
    <tr>
        <?foreach($reader_keys as $key) :?>
        <th><?=str_replace('_', ' ', $key)?></th>
        <?endforeach;?>
    </tr>
    <? foreach ($reader_data as $reader) :?>
    <tr>
        <?foreach($reader as $value) :?>
        <td><?=$value?></td>
        <?endforeach;?>
    </tr>
    <?endforeach;?>
</table>



