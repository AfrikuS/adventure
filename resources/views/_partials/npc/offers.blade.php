<b>Предложения</b>
<p></p>
<ul>
    @forelse($npcOffers as $offer)
        {{ link_to_route('npc_show_offer_page', $offer->task, ['id' => $offer->id])  }}
    @empty
        Нет NPC-offers
    @endforelse
</ul>

<p></p>
