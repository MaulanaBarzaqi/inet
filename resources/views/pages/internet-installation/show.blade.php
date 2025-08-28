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
                                    <td>{{ $item->user->email }}</td>
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
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>paket internet</th>
                                                <th>ideal device</th>
                                                <th>pemasangan</th>
                                                <th>bulanan</th>
                                            </tr>
                                                <tr>
                                                    <td>{{ $item->internetPackage->name }}</td>
                                                    <td>{{ $item->internetPackage->ideal_device }}</td>
                                                    <td>Rp. {{ number_format($item->internetPackage->installation, 0, ',', '.') }}</td>
                                                    <td>Rp. {{ number_format($item->internetPackage->monthly_bill, 0, ',', '.') }}</td>
                                                </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>total pembayaran</th>
                                    <td> Rp. {{ number_format($item->internetPackage->installation + $item->internetPackage->monthly_bill, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                            <div class="d-flex mt-3 justify-content">
                                <div class="">
                                    <a href="{{ route('internet-installation.status', $item->id) }}?status=approved" class="btn btn-success btn-block">
                                        <i class="fa fa-check"></i> set approved
                                    </a>
                                </div>
                                
                                <div class="mx-2">
                                    <a href="{{ route('internet-installation.status', $item->id) }}?status=pending" class="btn btn-warning btn-block">
                                        <i class="fa fa-spinner"></i> set pending
                                    </a>
                                </div>

                                <div class="">
                                    <a href="{{ route('internet-installation.status', $item->id) }}?status=rejected" class="btn btn-danger btn-block">
                                        <i class="fa fa-times"></i> set rejected
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                  </div>
@endsection