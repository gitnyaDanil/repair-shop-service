@extends('App')

@section('content-header', 'Daftar Order Perbaikan')


@php
$optionsStatus = [
    ['value' => 'diproses', 'text' => 'Sedang Diperbaiki'],
    ['value' => 'ditunda', 'text' => 'Perbaikan Ditunda'],
    ['value' => 'selesai', 'text' => 'Perbaikan Selesai'],
    ['value' => 'batal', 'text' => 'Perbaikan Dibatalkan'],
];
@endphp

@section('content')
<x-content>
    <x-row>
        <x-card-collapsible>
            <x-row>
                <x-col class="mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Tambah</button>
                </x-col>

                <x-col>
                    <x-table :thead="['Customer ', 'Tanggal Penerimaan', 'Tanggal Perkiraan Selesai', 'Status', 'Total Biaya', 'Aksi']">
                        @foreach ($repair_orders as $repair_order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $repair_order->first_name }} {{ $repair_order->last_name }}</td>
                                <td>{{ $repair_order->date_received }}</td>
                                <td>{{ $repair_order->estimated_completion_date }}</td>
                                <td>
                                    @php
                                        $optionsStatusColl = collect($optionsStatus);
                                        $status = $optionsStatusColl->where('value', $repair_order->status)->first();
                                        if ($status) {
                                            echo $status['text'];
                                        }
                                    @endphp
                                </td>
                                <td>{{ $repair_order->total_cost }}</td>
                                <td>
                                    <a
                                    href="{{ route('repair_order.show', $repair_order->id) }}"
                                    class="btn btn-warning"
                                    title="Ubah"><i class="fas fa-pencil-alt"></i></a>

                                    <form style=" display:inline!important;" method="POST" action="{{ route('repair_order.destroy', $repair_order->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                            title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </x-col>
            </x-row>
        </x-card-collapsible>
    </x-row>
</x-content>

<x-modal :title="'Tambah Data'" :id="'add-modal'" :size="'xl'">
    <form style="width: 100%" action="{{ route('repair_order.store') }}" method="POST">
        @csrf
        @method('POST')
        <!-- belum selesai -->

        <x-row>
            <x-in-select :label="'Customer'" :id="'customer_id'" :name="'customer_id'" :required="true"></x-in-select>
            <!-- <x-in-text col="4" :label="'Date'" :id="'date'" :name="'date'" :required="true" /> -->
            <x-in-text col="4" :type="'date'" :label="'Tanggal Diterima'" :id="'date_received'" :name="'date_received'" :required="true" />
            <x-in-text col="4" :type="'date'" :label="'Tanggal Perkiraan Selesai'" :id="'estimated_completion_date'" :name="'estimated_completion_date'" :required="true" />
            <x-in-select col="4" :label="'Status'" :id="'status'" :name="'status'" :required="true" :options="$optionsStatus" />
            {{-- plus button to add service and quantity --}}

            <x-col class="col-12">
                <button type="button" class="btn btn-primary" id="add-service">Tambah Layanan</button>
            </x-col>
        </x-row>

        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection

@push('js')
    <input type="hidden" id="url-customers" value="{{ route('select2.customers') }}">
    <input type="hidden" id="url-services" value="{{ route('select2.services') }}">

    <script>
        $(function() {
            //console.log('JavaScript loaded');
            $('#customer_id').select2({
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: {
                    id: '',
                    text: 'Pilih Customer'
                },
                ajax: {
                    url: $('#url-customers').val(),
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        //console.log('Sending AJAX request with params:', params);
                        return {
                            search: params.term // Send the search term to the server
                        };
                    },
                    processResults: function (data) {
                        const finalData = data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.first_name + ' ' + item.last_name // Display first and last name
                            };
                        });
                        return {
                            results: finalData
                        };
                    },
                    cache: false
                }
            });

            $('#add-service').on('click', function() {
                const html = `
                    <div class="row">
                        <div class="col-6">
                            <select class="form-control services" name="service_id[]">
                                <option value="">Pilih Layanan</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="number" class="form-control" name="quantity[]" placeholder="Jumlah" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger remove-service">Hapus</button>
                        </div>
                    </div>
                `;

                $('#add-service').after(html);

                $('.remove-service').on('click', function() {
                    $(this).closest('.row').remove();
                });
            });


            // when class services is clicked

            $(document).on('click', '.services', function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    allowClear: true,
                    placeholder: {
                        id: '',
                        text: 'Pilih Layanan'
                    },
                    ajax: {
                        url: $('#url-services').val(),
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            //console.log('Sending AJAX request with params:', params);
                            return {
                                search: params.term // Send the search term to the server
                            };
                        },
                        processResults: function (data) {
                            const finalData = data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name // Display first and last name
                                };
                            });
                            return {
                                results: finalData
                            };
                        },
                        cache: false
                    }
                });
            });

        });

    </script>
@endpush
