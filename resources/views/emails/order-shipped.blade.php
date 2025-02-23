<div style="display:block;width:100%;">
    Код заказа: {{ $order->code }}
</div>
<br/>
<div style="display:block;width:100%;">
    Имя: {{ $order->first_name }}
</div>
<br/>
<div style="display:block;width:100%;">
    Фамилия: {{ $order->last_name }}
</div>
<br/>
<div style="display:block;width:100%;">
    Город: {{ $order->city }}
</div>
<br/>
<div style="display:block;width:100%;">
    Телефон: {{ $order->phone }}
</div>
<br/>
<div style="display:block;width:100%;">
    Почта: {{ $order->email }}
</div>
<br/>
<div style="display:block;width:100%;">
    Дата заказа: {{ $order->created_at }}
</div>
