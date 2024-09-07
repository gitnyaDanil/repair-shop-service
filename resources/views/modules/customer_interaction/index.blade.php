@extends('App')

@section('content-header', 'Daftar Interaksi Customer')

@section('content')
<x-content>
    <x-row>
        <x-card-collapsible>
            <x-row>
                <x-col class="mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Tambah</button>
                </x-col>

                <x-col>
                    <x-table :thead="['Customer ', 'Tanggal', 'Catatan', 'Aksi']">
                        @foreach ($interactions as $interaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $interaction->first_name }} {{ $interaction->last_name }}</td>
                                <td>{{ $interaction->date }}</td>
                                <td>{{ $interaction->notes }}</td>
                                <td>
                                    <a
                                    href="{{ route('customer_interaction.show', $interaction->id) }}"
                                    class="btn btn-warning"
                                    title="Ubah"><i class="fas fa-pencil-alt"></i></a>

                                    <form style=" display:inline!important;" method="POST" action="{{ route('customer_interaction.destroy', $interaction->id) }}">
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
    <form style="width: 100%" action="{{ route('customer_interaction.store') }}" method="POST">
        @csrf
        @method('POST')
        <!-- belum selesai -->
        <x-row>
            <x-in-select
            :label="'Customer'"
            :placeholder="'Pilih Customer'"
            :col="6"
            :name="'customer_id'"
            :id="'customer_id'"
            :required="true"></x-in-select>
            <x-in-text col="6" :type="'date'" :label="'date'" :id="'date'" :name="'date'" :required="true" />
            <x-in-text col="12" :label="'Notes'" :id="'notes'" :name="'notes'" :required="true" />
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

    <script>
        $(function() 
        {
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
                        let query = {
                            search: params.term
                        }

                        return query;
                    },
                    processResults: function (data) {
                        const finalData = data.map(function(item) {
                            return {
                                id: item.id,
                                text: [item.first_name, item.last_name].join(' ')
                            }
                        });

                        return {
                            results: finalData
                        };
                    },
                    cache: false
                }
            });
        });
    </script>
@endpush
