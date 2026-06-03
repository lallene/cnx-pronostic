<div class="tab-pane fade {{ $active ? 'show active' : '' }}"
     id="{{ $tabId }}"
     role="tabpanel">

    <div class="wc-ranking-wrap">

        <div class="wc-ranking-header">
            <h3>{{ $title }}</h3>
        </div>

       <table
    id="{{ $tableId }}"
    class="wc-ranking-table"
    data-phase="{{ $phase }}"
>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Joueur</th>
                    <th>Service</th>
                    <th>Fonction</th>
                    <th>XP</th>
                    <th>Points</th>
                    <th>Progression</th>
                </tr>
            </thead>

        </table>

    </div>

</div>