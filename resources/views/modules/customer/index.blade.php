@extends('App')

@section('content-header', 'Daftar Customer')

@section('content')
<x-content>
    <x-row>
        <x-card-collapsible>
            <x-row>
                <x-col class="mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Tambah</button>
                </x-col>
            
                <x-col>
                    <x-table :thead="['Nama Depan', 'Nama Keluarga', 'Kontak', 'Alamat', 'Aksi']">
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->first_name }}</td>
                                <td>{{ $customer->last_name}}</td>
                                <td>{{ $customer->contact_info }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>
                                    <a
                                    href="{{ route('customer.show', $customer->id) }}"
                                    class="btn btn-warning"
                                    title="Ubah"><i class="fas fa-pencil-alt"></i></a>

                                    <form style=" display:inline!important;" method="POST" action="{{ route('customer.destroy', $customer->id) }}">
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
    <form style="width: 100%" action="{{ route('customer.store') }}" method="POST">
        @csrf
        @method('POST')

        <x-row>
            <x-in-text col="4" :label="'First Name'" :id="'first_name'" :name="'first_name'" :required="true" />
            <x-in-text col="4" :label="'Last Name'" :id="'last_name'" :name="'last_name'" :required="false" />
            <x-in-text col="4" :label="'Contact Info'" :id="'contact_info'" :name="'contact_info'" :required="false" />
            <x-in-text col="4" :label="'Address'" :id="'address'" :name="'address'" :required="false" />
        </x-row>
        
        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection