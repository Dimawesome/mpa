<textarea {{ isset($readonly) && $readonly ? 'readonly=readonly' : '' }}
          {{ isset($max) ? "maxlength=$max" : '' }}
          type="text"
          name="{{ $name }}"
          {{ isset($rows) ? "rows=$rows" : '' }}
          {{ isset($cols) ? "cols=$cols" : '' }}
          {{ isset($disabled) && $disabled ? 'disabled=disabled' : '' }}
          class="form-control{{ $classes }} {{ $class ?? '' }}">{{ $value ?? '' }}</textarea>
