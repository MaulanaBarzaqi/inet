@extends('layouts.default')

@section('content')
@section('title', 'Dashboard')
 <div class="row">
  {{-- card admin --}}
    <div class="col-lg-8 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Selamat admin {{ $admin->name ?? 'Admin' }}! 🎉</h5>
                  <p class="mb-4">
                    pelanggan internet anda saat ini <span class="fw-bold">72%</span> lebih banyak dari bulan lalu. Coba untuk meningkatkan layanan anda dengan paket internet yang lebih baik.
                  </p>
                </div>
             </div>
             <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img
                      src="{{ asset('../assets/img/illustrations/man-with-laptop-light.png') }}"
                      height="140"
                      alt="View Badge User"
                      data-app-dark-img="illustrations/man-with-laptop-dark.png"
                      data-app-light-img="illustrations/man-with-laptop-light.png"
                    />
                </div>
             </div>
          </div>
       </div>
    </div>
  {{-- 2 card --}}
    <div class="col-lg-4 col-md-4 order-1">
      <div class="row">
        {{-- paket internet --}}
         <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
               <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                      <h2 class="card-title mb-2">{{ $internetPackages }}</h2>
                      <div class="avatar flex-shrink-0">
                        <img src="{{ asset('../assets/img/icons/unicons/wifi.png') }}" alt="chart success" class="rounded"/>
                      </div>
                  </div>
                  <h3 class="card-title mb-2">Paket Internet</h3>
               </div>
            </div>
         </div>
         {{-- banner --}}
         <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <h2 class="card-title mb-2">{{ $banners }}</h2>
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('../assets/img/icons/unicons/banner.png') }}" alt="Credit Card" class="rounded"/>
                </div>
              </div>
              <h3 class="card-title mb-2">Banner mobile</h3>
            </div>
          </div>
         </div>
      </div>
    </div>
    {{-- pemasangan internet --}}
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
          <h5 class="card-header">Pemasangan Internet</h5>
        <div class="table-responsive text-nowrap p-3">
          <table class="table mb-3">
            <thead>
              <tr>
                <th>#</th>
                <th>nama</th>
                <th>WhatsApp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse ($installations as $installation )
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $installation->name }}</td>
                  <td>{{ $installation->phone }}</td>
                  <td>{{ $installation->user->email }}</td>
                  <td>{{ $installation->address }}</td>
                  <td>
                    @if ($installation->status == 'pending')
                        <span class="badge bg-label-warning">
                      @elseif ($installation->status == 'approved')
                        <span class="badge bg-label-success">
                      @elseif ($installation->status == 'rejected')
                        <span class="badge bg-label-danger">
                    @else
                      </span>
                    @endif
                      {{ $installation->status }}
                    </span>
                  </td>
                </tr>  
              @empty
                <tr>
                  <td colspan="12" class="text-center p-5">
                    Data tidak tersedia
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {{-- status --}}
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Pemasangan Internet</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column align-items-center gap-1">
                  <h2 class="mb-2">{{ $installationCount }}</h2>
                  <span>Installation internets</span>
                </div>
                <div id="orderStatisticsChart" 
                  data-approved="{{ $approved }}"
                  data-pending="{{ $pending }}"
                  data-rejected="{{ $rejected }}"
                ></div>
            </div>
            <ul class="p-0 m-0">
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-success">
                      <i class='bx bx-user-check'></i>
                    </span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Approved</h6>
                      <small class="text-muted">active</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold">{{ $approved }} pelanggan</small>
                    </div>
                  </div>
                </li>

                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-warning">
                      <i class='bx bx-user-voice'></i>
                    </span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Pending</h6>
                      <small class="text-muted">waiting to survey</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold">{{ $pending }} pelanggan</small>
                    </div>
                  </div>
                </li>

                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-danger">
                      <i class='bx bx-user-x' ></i>
                    </span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Rejected</h6>
                      <small class="text-muted">cancel internet installation</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold">{{ $rejected }} pelanggan</small>
                    </div>
                  </div>
                </li> 
            </ul>
         </div>
      </div>
    </div>
 </div>
@endsection

@push('after-script')
<script>
   document.addEventListener("DOMContentLoaded", function () {
        const chartOrderStatistics = document.querySelector("#orderStatisticsChart");
        if (chartOrderStatistics) {
            const approved = parseInt(chartOrderStatistics.dataset.approved) || 0;
            const pending = parseInt(chartOrderStatistics.dataset.pending) || 0;
            const rejected = parseInt(chartOrderStatistics.dataset.rejected) || 0;

            const orderChartConfig = {
                chart: {
                    height: 165,
                    width: 130,
                    type: "donut",
                },
                labels: ["approved", "pending", "rejected"],
                series: [approved, pending, rejected],
                colors: [
                    config.colors.success,
                    config.colors.warning,
                    config.colors.danger,
                ],
                stroke: {
                    width: 5,
                    colors: cardColor,
                },
                dataLabels: {
                    enabled: false,
                    formatter: function (val) {
                        return parseInt(val) + "%";
                    },
                },
                legend: { show: false },
                grid: {
                    padding: { top: 0, bottom: 0, right: 15 },
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "75%",
                            labels: {
                                show: true,
                                value: {
                                    fontSize: "1.5rem",
                                    fontFamily: "Public Sans",
                                    color: headingColor,
                                    offsetY: -15,
                                    formatter: function (val) {
                                        return parseInt(val) + "%";
                                    },
                                },
                                name: {
                                    offsetY: 20,
                                    fontFamily: "Public Sans",
                                },
                                total: {
                                    show: true,
                                    fontSize: "0.8125rem",
                                    color: axisColor,
                                    label: "Total",
                                    formatter: function (w) {
                                        const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        return total + " pelanggan";
                                    },
                                },
                            },
                        },
                    },
                },
            };

            const statisticsChart = new ApexCharts(
                chartOrderStatistics,
                orderChartConfig
            );
            statisticsChart.render();
        }
    });
</script>
  
@endpush