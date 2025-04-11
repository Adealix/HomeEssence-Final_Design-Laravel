@extends('layouts.base')

@section('body')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card profile-card">
                <div class="card-header text-center py-3">
                    <h3 class="page-title mb-0">{{ isset($customer) ? __('Edit Profile') : __('Create Profile') }}</h3>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <!-- Left Column: Profile Picture -->
                        <div class="col-md-4 text-center mb-4">
                            <div class="profile-image-container mb-3">
                                @if(isset($customer) && $customer->profile_picture)
                                    <img src="{{ Storage::url('profile_pictures/' . $customer->profile_picture) }}" 
                                         alt="Profile Picture" class="img-fluid rounded-circle profile-image">
                                @else
                                    <img src="{{ Storage::url('profile_pictures/defaultprofile.jpg') }}" 
                                         alt="Default Profile Picture" class="img-fluid rounded-circle profile-image">
                                @endif
                            </div>
                            <p class="text-muted small">Upload a profile picture to personalize your account</p>
                        </div>

                        <!-- Right Column: Customer Details Form -->
                        <div class="col-md-8">
                            @if(isset($customer))
                                <form method="POST" action="{{ route('customerprofile.update', $customer->id) }}" enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form method="POST" action="{{ route('customerprofile.store') }}" enctype="multipart/form-data">
                            @endif
                                @csrf

                                <div class="form-section mb-4">
                                    <h5 class="form-section-title">Personal Information</h5>
                                    
                                    <!-- Title Field as Dropdown -->
                                    <div class="row mb-3">
                                        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
                                        <div class="col-md-8">
                                            <select id="title" name="title" class="form-select @error('title') is-invalid @enderror">
                                                <option value="">{{ __('Select Title') }}</option>
                                                <option value="Mr." {{ old('title', isset($customer) ? $customer->title : '') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                                <option value="Ms." {{ old('title', isset($customer) ? $customer->title : '') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                                <option value="Mrs." {{ old('title', isset($customer) ? $customer->title : '') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                            </select>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- First Name Field -->
                                    <div class="row mb-3">
                                        <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>
                                        <div class="col-md-8">
                                            <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname', isset($customer) ? $customer->fname : '') }}" required>
                                            @error('fname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Last Name Field -->
                                    <div class="row mb-3">
                                        <label for="lname" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>
                                        <div class="col-md-8">
                                            <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname', isset($customer) ? $customer->lname : '') }}" required>
                                            @error('lname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section mb-4">
                                    <h5 class="form-section-title">Contact Details</h5>
                                    
                                    <!-- Address Line Field -->
                                    <div class="row mb-3">
                                        <label for="addressline" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                                        <div class="col-md-8">
                                            <textarea id="addressline" class="form-control @error('addressline') is-invalid @enderror" name="addressline" rows="3">{{ old('addressline', isset($customer) ? $customer->addressline : '') }}</textarea>
                                            @error('addressline')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Town Field -->
                                    <div class="row mb-3">
                                        <label for="town" class="col-md-4 col-form-label text-md-end">{{ __('Town') }}</label>
                                        <div class="col-md-8">
                                            <input id="town" type="text" class="form-control @error('town') is-invalid @enderror" name="town" value="{{ old('town', isset($customer) ? $customer->town : '') }}">
                                            @error('town')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Zipcode Field -->
                                    <div class="row mb-3">
                                        <label for="zipcode" class="col-md-4 col-form-label text-md-end">{{ __('Zipcode') }}</label>
                                        <div class="col-md-8">
                                            <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode', isset($customer) ? $customer->zipcode : '') }}">
                                            @error('zipcode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Field -->
                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                                        <div class="col-md-8">
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', isset($customer) ? $customer->phone : '') }}">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Profile Picture Field -->
                                <div class="row mb-4">
                                    <label for="profile_picture" class="col-md-4 col-form-label text-md-end">{{ __('Profile Picture') }}</label>
                                    <div class="col-md-8">
                                        <input id="profile_picture" type="file" class="form-control @error('profile_picture') is-invalid @enderror" name="profile_picture">
                                        @error('profile_picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary profile-submit">
                                            {{ __('Save Profile') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
