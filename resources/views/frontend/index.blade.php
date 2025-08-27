@extends('layouts.app')
@section('content')
    @include('frontend.sections.hero', ['heroData' => $heroData])
    @include('frontend.sections.about-us', ['aboutData' => $aboutData])
    @include('frontend.sections.floating-card')

    @include('frontend.sections.sponsor')

    @include('frontend.sections.connect')

    @include('frontend.sections.festival-category')
    @include('frontend.sections.media')

    @include('frontend.sections.events-highlights')

@endsection
