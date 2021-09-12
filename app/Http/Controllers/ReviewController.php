<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\ReviewsHelpful;
use App\Models\ReviewsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;

class ReviewController extends Controller
{
    public function reportReview(Request $request)
    {
        $customer = FacadesSession::get('customer');
        $review = DB::table('reviews')
            ->where([['id', '=', $request->review_id]])
            ->select('*')
            ->get();

        if (sizeof($review)) {

            $report = DB::table('review_report')
                ->where([
                    ['review_id', '=', $request->review_id],
                    ['customer_id', '=', $customer->id]
                ])
                ->select('*')
                ->get();

            if (!sizeof($report)) {

                $newReport = new ReviewsReport();

                $newReport->review_id = $request->review_id;
                $newReport->customer_id = $customer->id;
                $newReport->reason = $request->reportRadio;
                $newReport->comment = $request->addInfoReport;
                $newReport->save();

                FacadesSession::flash('status', ['0', 'Thank You! Your report has been submitted.']);
            } else {
                FacadesSession::flash('status', ['2', 'You already reported this review.']);
            }
        } else {
            FacadesSession::flash('status', ['1', 'Something went wrong. Please try again later!']);
        }
        return redirect()->back();
    }

    public function reviewHelpful(Request $request)
    {
        $customer = FacadesSession::get('customer');

        $review = DB::table('reviews')
            ->where([['id', '=', $request->review_id]])
            ->select('*')
            ->get();

        if (sizeof($review)) {

            $helpful = DB::table('review_helpful')
                ->where([['review_id', '=', $request->review_id], ['customer_id', '=',  $customer->id]])
                ->select('*')
                ->get();

            if (!sizeof($helpful)) {
                $newReviewHelpful = new ReviewsHelpful();

                $newReviewHelpful->review_id = $request->review_id;
                $newReviewHelpful->customer_id = $customer->id;
                $newReviewHelpful->helpful_count = '1';
                $newReviewHelpful->save();
            } else {
                DB::table('review_helpful')->where([['review_id', '=', $request->review_id], ['customer_id', '=',  $customer->id]])->delete();
            }

            $count = DB::table('review_helpful')->where([['review_id', '=', $request->review_id], ['customer_id', '=',  $customer->id]])->count();
            return $count;
        }

        return 0;
    }
}
