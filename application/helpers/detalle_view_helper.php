<?php

/**
 * Detalle vista  por segmento
 * @param bool]/string $title
 * @param bool/string $row
 * @param bool/string $ccs_class
 * @param bool/string $signo
 * @param bool/string $per
 * @return bool|string
 */
function details_show($title = FALSE, $row = FALSE, $ccs_class = FALSE, $signo = FALSE, $per = FALSE)
{
    if ($title) {
        $html = '<div class="' . $ccs_class . '">
                    <p class="card-text">
                        <em class="text-info">' . $title . ': </em>
                        '. $signo . ' ' . $row . ' '.  $per . '
                    </p>
                 </div>';
        return $html;
    } else {
        return FALSE;
    }
}
