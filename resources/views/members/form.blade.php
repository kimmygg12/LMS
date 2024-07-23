<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $member->name ?? '') }}" required>
</div>
<div class="form-group">
    <label for="name_latin">Name Latin</label>
    <input type="text" name="name_latin" class="form-control" value="{{ old('name_latin', $member->name_latin ?? '') }}">
</div>
<div class="form-group">
    <label for="gender">ភេទ</label>
    <select name="gender" class="form-control" required>
        <option value="male" {{ (old('gender', $member->gender ?? '') == 'male') ? 'selected' : '' }}>ប្រុស</option>
        <option value="female" {{ (old('gender', $member->gender ?? '') == 'female') ? 'selected' : '' }}>ស្រី</option>
    </select>
</div>
<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone ?? '') }}">
</div>
<div class="form-group">
    <label for="address">Address</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $member->address ?? '') }}">
</div>
<div class="form-group">
    <label for="dob">Date of Birth</label>
    <input type="date" name="dob" class="form-control" value="{{ old('dob', $member->dob ?? '') }}">
</div>
<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" class="form-control">
    @if (isset($member) && $member->image)
        <img src="{{ asset($member->image) }}" alt="Member Image" width="100">
    @endif
</div>
