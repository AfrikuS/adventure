<b>Движухи</b>
<p></p>
<ul>
    @forelse($npcDeals as $deal)
        {{ link_to_route('npc_show_offer_page', $deal->task, ['id' => $deal->id])  }}
    @empty
        Нет NPC-deals
    @endforelse
</ul>
