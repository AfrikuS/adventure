<?php

namespace App\Http\Controllers\Api\Work;

use App\Http\Controllers\Controller;
use App\Models\Work\Order;
use App\Repositories\Work\OrderRepositoryObj;
use Illuminate\Support\Collection;
use stdClass;

class AjaxComponentsController extends Controller
{
    public function orderLoading($chunkNumber)
    {
//        $orderRepo = new OrderRepositoryObj();
        /** @var Collection */
//        $orders = $orderRepo->getFreeOrders();

/*        оператором LIMIT, который вызывается с двумя параметрами -
            1/ с какой записи начинать, и
            2/ сколько выводить (внимание! не по какую, а сколько!)
            SELECT * FROM table LIMIT 0,10
*/
        $perChunk = 2;
        $chunks = $chunkNumber - 1;
        $orders = Order::
            select('id', 'price', 'desc') //, 'status', 'type')
            ->where('status', 'free')->where('type', 'individual')
            ->skip($chunks * $perChunk)->take($perChunk)
            ->get();


        $ordersDto = new stdClass;
        $ordersDto->count = $orders->count();
        $ordersDto->orders = $orders;

        return response()->json($ordersDto, 200, [], JSON_UNESCAPED_UNICODE);

    }
}
