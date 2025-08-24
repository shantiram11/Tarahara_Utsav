@extends('layouts.app')
@section('content')
    @include('frontend.sections.hero')
    @include('frontend.sections.about-us')
    @include('frontend.sections.floating-card')

    @include('frontend.sections.sponsor')

    @include('frontend.sections.connect')

    @include('frontend.sections.festival-category')
    @include('frontend.sections.media')

    @include('frontend.sections.events-highlights')

@endsection
