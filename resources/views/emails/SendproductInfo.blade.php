@component('mail::message')
# Hello,

ProductInfo : 

#product_name => {{ $product->product_name }}
#product_desc => {{ $product->product_desc }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
