@extends('layouts.app')
@section('content')
    @include('frontend.sections.hero', ['heroData' => $heroData])
    @include('frontend.sections.advertisements', ['advertisementsData' => $advertisementsData, 'only' => ['below_hero']])
    @include('frontend.sections.about-us', ['aboutData' => $aboutData])
    @include('frontend.sections.floating-card')

    @include('frontend.sections.sponsor')

    @include('frontend.sections.connect')

    @include('frontend.sections.festival-category', ['festivalCategoriesData' => $festivalCategoriesData])
    @include('frontend.sections.media')

    @include('frontend.sections.events-highlights')

@endsection
