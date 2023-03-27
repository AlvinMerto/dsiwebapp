<x-app-layout>
    <div class="br-mainpanel pd-15">
        <h1> Pending Permission </h1>
        <?php 
         // askingpermission/2/ac8e94aa945f27099a9cd094d3596018
            echo "<ul>";
                foreach($permissions as $p) {
                    $url = "quotes/{$p->inputby}/{$p->quoteid}/askingpermission/{$p->requestor}/{$p->thecode}/";
                    echo "<li>";
                        echo "<a href='".url($url)."'>".$p->quoteid."</a>";
                    echo "</li>";
                }
            echo "</ul>";
        ?>
    </div>
</x-app-layout>