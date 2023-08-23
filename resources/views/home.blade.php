@extends('layouts.app')

@section('content')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Names') }}</div>

                <div class="card-body">
                    @if (isset($famous_names))
                        <div class="d-flex flex-wrap">
                        @foreach ($famous_names as $person)
                            <div class="card ms-3 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $person['name'] }}</h5>
                                    <a href="#" onclick="openMap('{{ $person['name'] }}', {{ $person['location']['lat'] }}, {{ $person['location']['lng'] }})" class="card-link">View</a>
                                    <a href="#" class="card-link">Edit</a>
                                    <a href="#" class="card-link">Delete</a>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                        <div class="alert alert-danger">No data found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mapModalLabel">Map</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>
                <div class="modal-body" style="height: 80%;">
                    <div id="map" style="width: 100%; height: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>
</div>

@vite('resources/js/google_maps.js')

<script>
let map;

const height = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.documentElement.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight);
document.getElementById('map').style.height = (height - 250) + 'px';

function openMap(name, lat, lng) {
    openModal();

    initMap(name, lat, lng);
}

function openModal() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("mapModal").style.display = "block";
    document.getElementById("mapModal").classList.add("show");
}

function closeModal() {
    document.getElementById("backdrop").style.display = "none"
    document.getElementById("mapModal").style.display = "none"
    document.getElementById("mapModal").classList.remove("show")
}

async function initMap(name, lat, lng) {
    const position = { lat: lat, lng: lng };

    const { Map } = await google.maps.importLibrary("maps");
    map = new Map(document.getElementById("map"), {
        zoom: 14,
        center: position,
        mapId: "map",
    });

    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    // The marker, positioned at Uluru
    const marker = new AdvancedMarkerElement({
        map: map,
        position: position,
        title: name,
    });

    // Create a tooltip (InfoWindow)
    var infowindow = new google.maps.InfoWindow({
        content: '<b>' + name + '</b><br />Lat: ' + lat + '<br/>Lng: ' + lng
    });

    // Add a click event listener to the marker to open the tooltip
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
}
</script>
@endsection
