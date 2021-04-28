<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.2/css/bulma.css">

<form action="" style="width: 50%; margin-left: auto; margin-right: auto;">
    @csrf
    <div class="field">
        <label class="project-name" for="project-name">Name</label>

        <div class="control">
            <input class="input @error('project-name') is-danger @enderror" type="text"
                    name="project-name" id="project-name" value="{{  old('project-name') }}">

            @error('project-name')
                <p class="help is-danger">{{ $errors->first('project-name') }}</p>
            @enderror
        </div>
    </div>

    <div class="field">
        <label class="project-description" for="project-description">Describe</label>

        <div class="control">
            <input class="input @error('project-description') is-danger @enderror" type="text"
                    name="project-description" id="project-description"
                    value="{{  old('project-description') }}">

            @error('project-description')
                <p class="help is-danger">{{ $errors->first('project-description') }}</p>
            @enderror
        </div>
    </div>

    <!-- <label>Describe</label>
    <input type="text" placeholder="Enter a description for the project"> -->

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-link" type="submit">Create</button>
        </div>

        <div class="control">
            <button class="button" type="submit">Close</button>
        </div>
    </div>
</form>
