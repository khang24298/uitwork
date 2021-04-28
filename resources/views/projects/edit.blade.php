<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.2/css/bulma.css">

    <h1 class="heading has-text-weight-bold is-size-4">Update Project</h1>
            <form method="POST" action="/projects/{{ $project->id }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label" for="project_name">Name</label>

                    <div class="control">
                        <input class="input" type="text" name="project_name"
                        id="project_name" value="{{ $project->project_name }}">
                    </div>
                </div>

                <div class="field">
        <label class="description" for="description">Description</label>

        <div class="control">
            <input class="input @error('description') is-danger @enderror" type="text"
                    name="description" id="description"
                    value="{{  old('description') }}">

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-link" type="submit">Save</button>
        </div>

        <div class="control">
            <button class="button" type="submit">Cancel</button>
        </div>
    </div>
</form>
