<section id="stats_container" class="window<?php echo $this->isActive ? '' : ' inactive'; ?>">
    <article id="stats">
        <span class="legende Y"></span>
        <span class="legende X"></span>
    </article>
    <article id="listePtg"></article>
</section>
<script type="text/javascript">
    var stats   = <?php echo json_encode($stats); ?>,
        program = <?php echo json_encode($program); ?>,
        week    = {
            1: 'Lundi',
            2: 'Mardi',
            3: 'Mercredi',
            4: 'Jeudi',
            5: 'Vendredi',
            6: 'Samedi',
            7: 'Dimanche'
        },
        listMonths  = {
            1: 'Janvier',
            2: 'Février',
            3: 'Mars',
            4: 'Avril',
            5: 'Mai',
            6: 'Juin',
            7: 'Juillet',
            8: 'Août',
            9: 'Septembre',
            10: 'Octobre',
            11: 'Novembre',
            12: 'Décembre'
        };
</script>