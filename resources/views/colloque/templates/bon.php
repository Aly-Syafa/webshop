<html>
<head>
    <style type="text/css">
        @page { margin: 0; background: #fff; font-family: Arial, Helvetica, sans-serif; page-break-inside: auto;}
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/generate/common.css');?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/generate/bon.css');?>" media="screen" />
</head>
<body>

    <div class="content">
        <table id="content-table">
            <tr>
                <td colspan="2"><img height="80mm" src="<?php echo public_path('files/logos/'.$logo.''); ?>" alt="Unine logo" /></td>
            </tr>
            <tr><td colspan="2" height="5">&nbsp;</td></tr>
            <tr align="top">
                <td align="top" width="60%" valign="top">
                    <?php
                    if(!empty($expediteur)){
                        echo '<ul id="facdroit">';
                        foreach($expediteur as $line){
                            echo '<li>'.$line.'</li>';
                        }
                        echo '</ul>';
                    }
                    ?>

                    <div class="organisateur">
                        <h4>Organisé par:</h4>
                        <p><?php echo $colloque['organisateur']; ?></p>
                    </div>

                </td>
                <td align="top" width="40%" valign="top">
                    <?php
                        $adresse = $user->adresse_facturation;

                        if($adresse)
                        {
                            echo '<ul id="user">';
                            echo (!empty($adresse->company) ? '<li>'.$adresse->company.'</li>' : '');
                            echo '<li>'.$adresse->civilite_title.' '.$user->name.'</li>';
                            echo '<li>'.$adresse->adresse.'</li>';
                            echo (!empty($adresse->complement) ? '<li>'.$adresse->complement.'</li>' : '');
                            echo (!empty($adresse->cp) ? '<li>'.$adresse->cp_trim.'</li>' : '');
                            echo '<li>'.$adresse->npa.' '.$adresse->ville.'</li>';
                            echo '</ul>';
                        }
                    ?>

                </td>
            </tr>
            <tr><td colspan="2" height="25">&nbsp;</td></tr>
        </table>
    </div>

    <div class="content">
        <h1 class="title blue">BON DE PARTICIPATION <?php echo $invitation_no; ?></h1>
        <p class="red"><small>A présenter lors de votre arrivée</small></p>
        <table id="content-table" valign="top">
            <tr><td height="5">&nbsp;</td></tr>
            <tr valign="top">
                <td class="content-wide" valign="top">
                    <h2><?php echo $colloque['titre']; ?></h2>
                    <h3><?php echo $colloque['soustitre']; ?></h3>
                    <h3><?php echo $colloque['date']; ?></h3>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table id="content-table" valign="top">
            <tr><td colspan="2" height="15">&nbsp;</td></tr>
            <tr valign="top">
                <td width="120mm" valign="top">
                    <img style="max-width: 120mm" src="<?php echo public_path('files/colloques/cartes/'.$carte.''); ?>" alt="Carte" />
                </td>
                <td width="5mm">&nbsp;</td>
                <td width="65mm" class="infos" valign="top">

                    <h4>Lieu:</h4>
                    <p>Aula des Jeunes-Rives, Espace Louis-Agassiz 1, Neuchâtel</p>

                    <h4>Choix:</h4>
                    <p>Je participerai au repas de vendredi midi</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>