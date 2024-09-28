@extends('admin.layout.app')

@section('content')
<div class="container">
    <h2>Create Itinerary</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <form method="POST" action="{{ route('admin.itineraries.store') }}">
        @csrf
        
        <div class="mb-3">
            <label for="tour_id" class="form-label">Select Package</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                <option value="">Select Package</option>
                @foreach($popularTours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->package_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="day_no" class="form-label">Day Number</label>
            <input type="number" name="day_no" id="day_no" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
           
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" required>
                </div>
        
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>
        
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Create Itinerary</button>
                    <button type="button" onclick="window.history.back();" class="btn btn-secondary">Back</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('tour_id').addEventListener('change', checkItinerary);
            document.getElementById('day_no').addEventListener('input', checkItinerary);
        
            function checkItinerary() {
                const tourId = document.getElementById('tour_id').value;
                const dayNo = document.getElementById('day_no').value;
        
                if (tourId && dayNo) {
                    axios.get(`{{ route('admin.itineraries.checkTitle') }}`, {
                        params: {
                            tour_id: tourId,
                            day_no: dayNo
                        }
                    })
                    .then(response => {
                        const titleInput = document.getElementById('title');
                        if (response.data.title) {
                            titleInput.value = response.data.title;
                            titleInput.readOnly = true; // Make it read-only if the title exists
                        } else {
                            titleInput.value = '';
                            titleInput.readOnly = false; // Allow editing if no title is found
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching title:', error);
                    });
                }
            }
        </script>

        {{-- <script>
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.getElementById('tour_id').addEventListener('change', checkItinerary);
            document.getElementById('day_no').addEventListener('input', checkItinerary);
        
            function checkItinerary() {
                const tourId = document.getElementById('tour_id').value;
                const dayNo = document.getElementById('day_no').value;
                const route = "{{ route('admin.itineraries.checkTitle') }}";
        
                if (tourId && dayNo) {
                    fetch(`${route}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data); // Log the data to inspect the response
                        const titleInput = document.getElementById('title');
                        if (data.title) {
                            titleInput.value = data.title;
                            titleInput.readOnly = true;
                        } else {
                            titleInput.value = '';
                            titleInput.readOnly = false;
                        }
                    })
                    .catch(error => console.error('Error fetching title:', error));

                }
            }
        </script> --}}
        @endsection
        