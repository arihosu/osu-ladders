<?php
	/***
	** display.php
	** Outputs the requested data
	** to awful HTML "code"
	***/

  function printTable($data) 
  {
    printf("<h3 class='center' style='margin-bottom: -45px;'>%s</h3>", $data[0]['fromladder']);
    $i = 1;
  	foreach ($data as $key => $value)
    {
        if ($data[$key]['laddermaster'] == 1)
        {
            $color = "#F9C9C9";
        } else
        {
            $color = "#fff";
        }
        $country = strtolower($data[$key]['country']);
        printf("<tr style='background: %s;'>
                    <td>%s</td>
                    <td><a href='https://osu.ppy.sh/u/%s'>%s</a> <img class='flag' src='/ladder/img/$country.png' name='$country' alt='($country)'></td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                </tr>",
                $color,
                $i,
                $data[$key]['username'],
                $data[$key]['username'],
                number_format($data[$key]['pp_raw']),
                number_format($data[$key]['pp_rank']),
                round($data[$key]['accuracy'], 2),
                number_format($data[$key]['playcount']
                ));
        $i++;
    }
  }
 ?>