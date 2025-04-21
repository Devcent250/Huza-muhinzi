<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Welcome to Huza Muhinzi') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/agriculture-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }

        .feature-card {
            transition: transform 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .product-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .why-choose-us {
            background-color: #f8f9fa;
        }

        .cta-section {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4">{{ __('Welcome to Huza Muhinzi') }}</h1>
            <p class="lead mb-5">{{ __('Connecting farmers and suppliers for a better agricultural future') }}</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">{{ __('Register Now') }}</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">{{ __('Login') }}</a>
            </div>
        </div>
    </section>

    <!-- For Cooperatives & Suppliers Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-success mb-3"></i>
                            <h3>{{ __('For Cooperatives') }}</h3>
                            <p>{{ __('Join our platform to connect with suppliers, manage your products, and grow your cooperative business.') }}</p>
                            <a href="{{ route('register') }}?type=cooperative" class="btn btn-outline-success">
                                {{ __('Register as Cooperative Member') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-truck fa-3x text-success mb-3"></i>
                            <h3>{{ __('For Suppliers') }}</h3>
                            <p>{{ __('Find quality agricultural products, connect with cooperatives, and expand your supply network.') }}</p>
                            <a href="{{ route('register') }}?type=supplier" class="btn btn-outline-success">
                                {{ __('Register as Supplier') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Easy Access Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2>{{ __('Easy Access') }}</h2>
                <p class="lead">{{ __('Access our platform through SMS or USSD. Stay updated with market prices and connect with partners.') }}</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                    <i class="fas fa-mobile-alt fa-4x text-success mb-3"></i>
                    <h4>SMS & USSD</h4>
                    <p>*157*1#</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Available Products') }}</h2>
            <div class="row g-4">
                @php
                $products = [
                ['name' => 'Irish Potatoes', 'icon' => 'fa-seedling'],
                ['name' => 'Rice', 'icon' => 'fa-wheat-awn'],
                ['name' => 'Coffee', 'icon' => 'fa-mug-hot'],
                ['name' => 'Fruits', 'icon' => 'fa-apple-whole'],
                ['name' => 'Vegetables', 'icon' => 'fa-carrot']
                ];
                @endphp

                @foreach($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card product-card text-center">
                        <div class="card-body">
                            <i class="fas {{ $product['icon'] }} fa-2x text-success mb-3"></i>
                            <h5 class="card-title">{{ __($product['name']) }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Why Choose Us?') }}</h2>
            <div class="row g-4">
                @php
                $features = [
                ['title' => 'Direct connection between farmers and suppliers', 'icon' => 'fa-link'],
                ['title' => 'Real-time market prices and product information', 'icon' => 'fa-chart-line'],
                ['title' => 'SMS and USSD accessibility for all users', 'icon' => 'fa-mobile-screen'],
                ['title' => 'Secure and transparent transactions', 'icon' => 'fa-shield-halved'],
                ['title' => 'Available in English and Kinyarwanda', 'icon' => 'fa-language']
                ];
                @endphp

                @foreach($features as $feature)
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas {{ $feature['icon'] }} fa-2x text-success mb-3"></i>
                        <h5>{{ __($feature['title']) }}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section py-5">
        <div class="container text-center">
            <h2 class="mb-4">{{ __('Ready to Get Started?') }}</h2>
            <p class="lead mb-4">{{ __('Join our growing community of farmers and suppliers') }}</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">{{ __('Register Now') }}</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">{{ __('Login') }}</a>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
