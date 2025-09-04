@extends('layouts.default')

@section('content')
@section('title', 'Pemasangan - Detail Pemasangan Internet')
     <div class="card mb-4">
                    <h5 class="card-header">Pemasangan Detail</h5>
                    
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $item->name }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $item->nik }}</td>
                                </tr>
                                <tr>
                                    <th>WhatsApp</th>
                                    <td>{{ $item->phone }}</td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td>
                                        @if($item->user)
                                            {{ $item->user->email }}
                                        @elseif($item->user_id)
                                            <span class="badge bg-danger">Akun telah dihapus (ID: {{ $item->user_id }})</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada akun terkait</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>alamat</th>
                                    <td>{{ $item->address }}</td>
                                </tr>
                                <tr>
                                    <th>status</th>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge bg-label-warning">
                                        @elseif ($item->status == 'approved')
                                            <span class="badge bg-label-success">
                                        @elseif ($item->status == 'rejected')
                                            <span class="badge bg-label-danger">
                                        @else
                                            </span>
                                        @endif
                                            {{ $item->status }}
                                            </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>berlangganan</th>
                                    <td>
                                        @if (is_null($item->internet_package_id))
                                            <span class="badge bg-label-secondary">Tidak Ada Paket Internet</span>
                                        @elseif ($item->internetPackage)
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Paket Internet</th>
                                                    <th>Ideal Devices</th>
                                                    <th>Biaya Pemasangan</th>
                                                    <th>Biaya Bulanan</th>
                                                </tr>
                                                <tr>
                                                    <td>{{ $item->internetPackage->name }}</td>
                                                    <td>{{ $item->internetPackage->ideal_device }}</td>
                                                    <td>Rp. {{ number_format($item->internetPackage->installation, 0, ',', '.') }}</td>
                                                    <td>Rp. {{ number_format($item->internetPackage->monthly_bill, 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        @else
                                            <span class="badge bg-label-danger">Paket internet dihapus (ID: {{ $item->internet_package_id }})</span>
                                        @endif
                                    </td>
                                </tr>
                                @if ($item->internetPackage)
                                    <tr>
                                        <th>total pembayaran</th>
                                        <td> Rp. {{ number_format($item->internetPackage->installation + $item->internetPackage->monthly_bill, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </table>

                            <div class="d-flex mt-3 justify-content">
                                <form action="{{ route('internet-installation.status', $item->uuid) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa fa-check">set approved</i>
                                    </button>
                                </form>

                                <form action="{{ route('internet-installation.status', $item->uuid) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="btn btn-warning btn-block">
                                        <i class="fa fa-check">set pending</i>
                                    </button>
                                </form>

                                <form action="{{ route('internet-installation.status', $item->uuid) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fa fa-check">set rejected</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                  </div>
@endsection