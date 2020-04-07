@if (auth()->check())
   @if (auth()->user()->is_admin = true)
       <div>
           <form action="{{ route('review.destroy', ['review' => $review->id]) }}" method="POST">
               @csrf
               @method('delete')

               <button class="btn btn-danger btn-sm" type="submit">{{ __('view.deleteReview') }}</button>
           </form>
       </div>
   @endif
@endif
