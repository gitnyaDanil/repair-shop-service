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
                    <x-table :thead="['Customer ID', 'Tanggal', 'Catatan', 'Aksi']">
                        @foreach ($interactions as $interaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $interaction->customer_id }}</td>
                                
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
            <x-in-text col="2" :label="'Customer ID'" :id="'customer_id'" :name="'customer_id'" :required="true" />
            <!-- <x-in-text col="4" :label="'Date'" :id="'date'" :name="'date'" :required="true" /> -->
            <input type="date" name="date" id="date" class="form-control" required>
            <x-in-text col="8" :label="'Notes'" :id="'notes'" :name="'notes'" :required="true" />
        </x-row>
        
        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection