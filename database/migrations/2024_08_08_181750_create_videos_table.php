<?php

use App\Enums\VideoStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();
            $table->foreignId('lecture_id')->constrained()->cascadeOnDelete();
            $table->string('original_file_name');
            $table->string('temp_disk')->default(config('site.disks.videos.temp'));
            $table->string('stream_disk')->default(config('site.disks.videos.stream'));
            $table->string('temp_path')->nullable();
            $table->string('stream_name')->nullable();
            $table->decimal('processing_percent', 10, 2)->nullable();
            $table->decimal('duration_seconds', 10, 2)->default(0);
            $table->string('mime_type')->nullable();
            $table->datetime('uploaded_at')->nullable();
            $table->datetime('processing_ended_at')->nullable();
            $table->string('status')->default(VideoStatus::UPLOADED->value);
            $table->text('failure_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
