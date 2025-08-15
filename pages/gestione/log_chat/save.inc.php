<?php
if (($_SESSION['permessi'] < MODERATOR) || ($PARAMETERS['mode']['spymessages'] != 'ON')){
    echo '<div class="error">'.gdrcd_filter('out',$MESSAGE['error']['not_allowed']).'</div>';
} else {
    switch ($_POST['op']) {
        # Cancella account
        case 'view_user':
                     
            //Determinazione pagina (paginazione)
            $pagebegin = (int) $_REQUEST['offset'] * $PARAMETERS['settings']['records_per_page'];
            $pageend = $PARAMETERS['settings']['records_per_page'];
            //Conteggio record totali
            $record_globale = gdrcd_query("SELECT COUNT(*) FROM chat WHERE mittente = '" . gdrcd_filter('get',
                    $_REQUEST['pg']) . "'");
            $totaleresults = $record_globale['COUNT(*)'];
             //Lettura record
            $result = gdrcd_query("SELECT chat.destinatario, chat.tipo, chat.ora, chat.testo, mappa.nome FROM chat JOIN mappa on chat.stanza=mappa.id WHERE chat.mittente = '" . $_REQUEST['pg'] . "' ORDER BY ora DESC LIMIT " . $pagebegin . ", " . $pageend . "",
                'result');
            $numresults = gdrcd_query($result, 'num_rows');

            /* Se esistono record */
            if ($numresults > 0) {
                echo <<<HTML
                <!-- Elenco dei record paginato -->
                <div class="elenco_record_gestione">
                    <table>
                        <!-- Intestazione tabella -->
                        <tr>
                            <td class="casella_titolo">
                                <div class="titoli_elenco">
                HTML;
                echo gdrcd_filter('out', $MESSAGE['interface']['administration']['log']['chat']['sender']);
                echo <<<HTML
                                </div>
                            </td>
                            <td class="casella_titolo">
                                <div class="titoli_elenco">
                HTML;
                echo gdrcd_filter('out', $MESSAGE['interface']['administration']['log']['chat']['date']);
                echo <<<HTML
                                </div>
                            </td>
                            <td class="casella_titolo">
                                <div class="titoli_elenco">
                HTML;
                echo gdrcd_filter('out', $MESSAGE['interface']['administration']['log']['chat']['text']);
                echo <<<HTML
                                </div>
                            </td>
                        </tr>
                        <!-- Record -->
                HTML;
                while ($row = gdrcd_query($result, 'fetch')) {
                    echo <<<HTML
                            <tr class="risultati_elenco_record_gestione">
                                <td class="casella_elemento">
                                    <div class="elementi_elenco">
                HTML;
                    echo gdrcd_filter('out', $row['nome']);
                    echo <<<HTML
                                    </div>
                                </td>
                                <td class="casella_elemento">
                                    <div class="elementi_elenco">
                HTML;
                    echo gdrcd_format_datetime($row['ora']);
                    echo <<<HTML
                                    </div>
                                </td>
                                <td class="casella_elemento">
                                    <div class="elementi_elenco">
                HTML;
                    if (empty($row['destinatario']) === false) {
                        echo '(-> ' . gdrcd_filter('out', $row['destinatario']) . ') ';
                    }
                    echo gdrcd_filter('out', $row['testo']);
                    echo <<<HTML
                                    </div>
                                </td>
                            </tr>
                HTML;
                } //while
                echo <<<HTML
                    </table>
                </div>
                HTML;
            }//if
            
            echo <<<HTML
            <!-- Paginatore elenco -->
            <div class="pager">
            HTML;
            if ($totaleresults > $PARAMETERS['settings']['records_per_page']) {
                echo gdrcd_filter('out', $MESSAGE['interface']['pager']['pages_name']);
                for ($i = 0; $i <= floor($totaleresults / $PARAMETERS['settings']['records_per_page']); $i++) {
                    if ($i != $_REQUEST['offset']) {
                        $page_num = $i + 1;
                        echo <<<HTML
                        <a href="main.php?page=log_chat&op=view&pg={$_REQUEST['pg']}&offset={$i}">{$page_num}</a>
HTML;
                    } else {
                        echo ' ' . ($i + 1) . ' ';
                    }
                } //for
            }//if
            echo <<<HTML
            </div>
            HTML;
            break;

        case 'view_date':
            //Determinazione pagina (paginazione)
            $pagebegin = (int) $_REQUEST['offset'] * $PARAMETERS['settings']['records_per_page'];
            $pageend = $PARAMETERS['settings']['records_per_page'];
            //Conteggio record totali
            $record_globale = gdrcd_query("SELECT COUNT(*) FROM chat WHERE stanza = '" . gdrcd_filter('get',
                    $_REQUEST['luogo']) . "'");
            $totaleresults = $record_globale['COUNT(*)'];
            $data_a=gdrcd_format_datetime_standard($_REQUEST['data_a']);
            $data_b= gdrcd_format_datetime_standard($_REQUEST['data_b']);
            $query="SELECT chat.mittente, chat.destinatario, chat.tipo, chat.ora, chat.testo FROM chat WHERE chat.stanza = '" . gdrcd_filter('get',
                    $_REQUEST['luogo']) . "' AND ora >= '" . $data_a  . "' AND ora <= '" . $data_b . "' ORDER BY ora DESC LIMIT " . $pagebegin . ", " . $pageend;

            //Lettura record
            $result = gdrcd_query($query,'result');
            $numresults = gdrcd_query($result, 'num_rows');
            /* Se esistono record */
            if ($numresults > 0) {
                echo <<<HTML
                <!-- Elenco dei record paginato -->
                <div class="elenco_record_gestione">
                    <table>
                        <!-- Intestazione tabella -->
                        <tr>
                            <td class="casella_titolo">
                                <div class="titoli_elenco">
                HTML;
                echo gdrcd_filter('out', $MESSAGE['interface']['administration']['log']['chat']['sender']);
                echo <<<HTML
                                </div>
                            </td>
                            <td class="casella_titolo">
                                <div class="titoli_elenco">
                HTML;
                echo gdrcd_filter('out', $MESSAGE['interface']['administration']['log']['chat']['date']);
                echo <<<HTML
                                </div>
                            </td>
                            <td class="casella_titolo">
                                <div class="titoli_elenco">
                HTML;
                echo gdrcd_filter('out', $MESSAGE['interface']['administration']['log']['chat']['text']);
                echo <<<HTML
                                </div>
                            </td>
                        </tr>
                        <!-- Record -->
                    HTML;
                while ($row = gdrcd_query($result, 'fetch')) {
                    echo <<<HTML
                            <tr class="risultati_elenco_record_gestione">
                                <td class="casella_elemento">
                                    <div class="elementi_elenco">
                    HTML;
                    echo gdrcd_filter('out', $row['mittente']);
                    echo <<<HTML
                                    </div>
                                </td>
                                <td class="casella_elemento">
                                    <div class="elementi_elenco">
                    HTML;
                    echo gdrcd_format_datetime($row['ora']);
                    echo <<<HTML
                                    </div>
                                </td>
                                <td class="casella_elemento">
                                    <div class="elementi_elenco">
                    HTML;
                    if (empty($row['destinatario']) === false) {
                        echo '(-> ' . gdrcd_filter('out', $row['destinatario']) . ') ';
                    }
                    echo gdrcd_filter('out', $row['testo']);
                    echo <<<HTML
                                    </div>
                                </td>
                            </tr>
                    HTML;
                } //while
                gdrcd_query($result, 'free');
                echo <<<HTML
                    </table>
                </div>
                HTML;
            }//if
            
            echo <<<HTML
            <!-- Paginatore elenco -->
            <div class="pager">
            HTML;
            if ($totaleresults > $PARAMETERS['settings']['records_per_page']) {
                echo gdrcd_filter('out', $MESSAGE['interface']['pager']['pages_name']);
                for ($i = 0; $i <= floor($totaleresults / $PARAMETERS['settings']['records_per_page']); $i++) {
                    if ($i != $_REQUEST['offset']) {
                        $luogo_filtered = gdrcd_filter('get', $_REQUEST['luogo']);
                        $page_num = $i + 1;
                        echo <<<HTML
                        <a href="main.php?page=log_chat&op=view&luogo={$luogo_filtered}&data_a={$data_a}&data_b={$data_b}&offset={$i}">{$page_num}</a>
                        HTML;
                    } else {
                        echo ' ' . ($i + 1) . ' ';
                    }
                } //for
            }//if
            echo <<<HTML
            </div>
            HTML;
            break;
        default:
            die('Operazione non riconosciuta.');
    }
}
echo <<<HTML
<!-- Link a piè di pagina -->
<div class="link_back">
    <a href="main.php?page=log_chat">Torna indietro</a>
</div>
HTML;
?>
