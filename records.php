<?php

function appendMyRecordsToResponse($data, $category)
{
    $r = '<div class="containerrecord text-center"></div><div class="table-container">
        <table class="table table-borderless table-hover text-center"><thead>
        <tr><th>Period</th><th>Select</th><th>Result</th><th>Outcome</th></tr></thead><tbody>';

    foreach ($data as $result) {
        $color = !empty((int)($result['selection'])) ? $result['selection'] % 2 == 0 ? 'red' : 'green' : $result['selection'];

        $color != 'violet' ? : $color = 'darkviolet';

        $outcome =  match ((int) $result['status']) {
            1 => ['class' => 'green', 'text' => '+'.$result['amount'] * 1.9 ],
            2 => ['class' =>'red', 'text' => '-'. $result['amount'] ],
            3 => ['class' =>'darkviolet', 'text' => '+'. $result['amount'] * 1.45 ],
            4 => ['class' =>'blue', 'text' => '+'. $result['amount'] * 8.55 ],
            default => ['class' => 'orange', 'text' => 'awaiting' ],
        };

        $gameResult =  getResultForGame($result['game_id'], $category, $result['selection']);

        $r = $r . '<tr>
                     <td>' .$result['game_id'] . '</td>
                     <td><span style="color:'.$color.'">' . $result['selection'] . '</span></td>
                     <td>'.$gameResult.'</td>
                     <td><span style="color:'.$outcome["class"].'">'.$outcome["text"].'</span></td>
                   </tr>';

    }

    return $r. '</tbody></table>';
}


function getResultForGame($gameId, $category, $selection)
{
    $result = (new App\Models\Model('games'))->where('id', $gameId)->where('type', $category)
        ->first();

    if(empty($result)) {
        return '<span style="color:orange">---</span>';
    }

    else {
        $output = $result['number'];

        $color = ($result['number']) % 2 === 0 ? 'red' : 'green';

        if (in_array($selection, ['green', 'red', 'violet'])) {
            $output = !in_array($output, [0, 5]) ? ($output % 2 === 0 ? 'red' : 'green') : ($output == 0 ? 'red,violet' : 'green,violet');

            return match ($output) {
                'red,violet' => '<span style="color:red">red</span>, <span style="color:darkviolet">violet</span>',
                'green,violet' => '<span style="color:green">green</span>, <span style="color:darkviolet">violet</span>',
                default => '<span style="color:'.$color.'">' . $output . '</span>',
            };
        }

        return '<span style="color:'.$color.'">' . $output . '</span>';
    }
}
