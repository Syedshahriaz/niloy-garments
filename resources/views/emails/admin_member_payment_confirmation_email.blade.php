A new member has been completed the payment. <br>
Member Details <br>
<table>
    <tr style="text-align: left;">
        <th>User Id</th>
        <th>{{$user->unique_id}}</th>
    </tr>
    <tr style="text-align: left;">
        <th>User Name</th>
        <th>{{$user->username}}</th>
    </tr>
    <tr style="text-align: left;">
        <th>Phone</th>
        <th>{{$user->phone}}</th>
    </tr>
</table> <br> <br>

Payment Details <br>
<table>
    <tr style="text-align: left;">
        <th>Amount</th>
        <th>{{$payment->amount}}</th>
    </tr>
    <tr style="text-align: left;">
        <th>Transaction ID</th>
        <th>{{$payment->txn_id}}</th>
    </tr>
    <tr style="text-align: left;">
        <th>Date</th>
        <th>{{$payment->payment_date}}</th>
    </tr>
</table>
