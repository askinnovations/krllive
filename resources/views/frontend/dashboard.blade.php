@extends('frontend.layouts.dashboard-app')
@section('title') {{ 'contact' }} @endsection
@section('content')
<main class="main">
        <section class="res">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Total No. of Order</h4>
                                <h3>102</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Recent Order</h4>
                                <h3>06</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Order Confirmed</h4>
                                <h3>89</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Order Completed</h4>
                                <h3>86</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <!-- Order Booking Table Section -->
            <div class="card shadow-sm p-4 mt-4">
                <div
                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
                    <div>
                        <h5><i class="fas fa-box-open me-2 text-warning"></i>Recent Order</h5>
                        <p class="text-muted mb-2 mb-sm-0">Track your most recent orders and manage their status easily.
                        </p>
                    </div>

                    <a href="#" class="btn btn-danger rounded mt-2 mt-sm-0" data-bs-toggle="modal"
                        data-bs-target="#addOrderModal">
                        <i class="fas fa-plus"></i> Add Order Booking
                    </a>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Order ID</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ $order->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                                    <td>
                                        @php
                                            // Bootstrap badge class based on status
                                            switch(strtolower($order->status)) {
                                                case 'pending':
                                                    $badge = 'warning text-dark';
                                                    break;
                                                case 'processing':
                                                case 'confirmed':
                                                    $badge = 'success';
                                                    break;
                                                case 'completed':
                                                    $badge = 'primary';
                                                    break;
                                                case 'cancelled':
                                                    $badge = 'danger';
                                                    break;
                                                default:
                                                    $badge = 'secondary';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.order-details', $order->order_id) }}">
                                            <button class="btn btn-sm btn-light text-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Add Order Modal -->
        <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderModalLabel"><i class="fas fa-plus-circle me-2"></i>New Order
                            Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @php
                        use App\Models\Destination;
                        $destinations = Destination::all();
                    @endphp

                    <form action="{{ route('order.save') }}" method="POST">
                            {{-- Hidden user_id --}}
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" required placeholder="Order description">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">From Destination</label>
                                    <select name="from_destination_id" class="form-control" required>
                                        <option value="">-- Select From --</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">To Destination</label>
                                    <select name="to_destination_id" class="form-control" required>
                                        <option value="">-- Select To --</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Date</label>
                                    <input type="date" name="order_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Order</button>
                            </div>
                    </form>

                </div>
            </div>
        </div>


    </main>

@endsection