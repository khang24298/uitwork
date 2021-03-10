<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.2/css/bulma.css">

<form action="" style="width: 50%; margin-left: auto; margin-right: auto;">
    @csrf
    <div class="field">
        <label class="project_name" for="project_name">Name</label>

        <div class="control">
            <input class="input @error('project-name') is-danger @enderror" type="text"
                    name="project_name" id="project_name" value="{{  old('project_name') }}">

            @error('project_name')
                <p class="help is-danger">{{ $errors->first('project_name') }}</p>
            @enderror
        </div>
    </div>

    <div class="field">
        <label class="description" for="description">Describe</label>

        <div class="control">
            <input class="input @error('description') is-danger @enderror" type="text"
                    name="description" id="description" value="{{  old('description') }}">

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-link" type="submit">Create</button>
        </div>

        <div class="control">
            <button class="button" type="submit">Close</button>
        </div>
    </div>
</form>
