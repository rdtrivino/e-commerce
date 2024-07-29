@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Carrito de Compras</h1>
        @if (session('cart'))
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('cart') as $id => $details)
                        <tr>
                            <td>{{ $details['name'] }}</td>
                            <td>
                                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                            </td>
                            <td>${{ $details['price'] }}</td>
                            <td>${{ $details['price'] * $details['quantity'] }}</td>
                            <td>
                                <button class="btn btn-info btn-sm update-cart"
                                    data-id="{{ $id }}">Actualizar</button>
                                <button class="btn btn-danger btn-sm remove-from-cart"
                                    data-id="{{ $id }}">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <strong>Total: ${{ array_sum(array_column(session('cart'), 'price')) }}</strong>
            </div>
        @else
            <p>El carrito está vacío.</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".update-cart").click(function(e) {
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: ele.attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function(e) {
            e.preventDefault();
            var ele = $(this);

            if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: ele.attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection
