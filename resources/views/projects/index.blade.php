@foreach ($projects as $project)
    <div id="content">
        <div class="project_name">
            <h2>
                <a href="/projects/{{ $project->id }}">{{ $project->project_name }}</a>
            </h2>
        </div>

        <p>{{ $project->description }}</p>
    </div>
@endforeach
