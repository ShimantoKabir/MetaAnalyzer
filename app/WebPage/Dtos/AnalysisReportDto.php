<?php

namespace App\WebPage\Dtos;

class AnalysisReportDto
{
  public bool $isIssueFound;
  public string $message;

  /**
   * This field contain analysis issues
   *
   * @var array<string>
   */
  public array $issues = [];
}
