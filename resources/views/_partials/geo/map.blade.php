<p></p>
World Map
@if(count($locationsCollection) > 0)
    <table class="table table-condensed">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Location</th>
                <th>next_paths</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locationsCollection as $location)
                <tr>
                    <td>{{ $location->title }}</td>
                    <td>
                        <ul>
                            @foreach($location->nextLocations as $next)
                                <li>{{ $next->title }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </table>
@else
    Локаций нет
@endif
