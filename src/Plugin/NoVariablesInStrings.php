<?php

namespace SamLitowitz\Psalm\Plugin;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\Encapsed;
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\Context;
use Psalm\FileManipulation;
use Psalm\IssueBuffer;
use Psalm\Plugin\Hook\AfterExpressionAnalysisInterface;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use Psalm\StatementsSource;
use SamLitowitz\Psalm\Issue\VariableInString;
use SimpleXMLElement;

final class NoVariablesInStrings implements PluginEntryPointInterface, AfterExpressionAnalysisInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(RegistrationInterface $api, SimpleXMLElement $config = null)
    {
        // TODO: Implement __invoke() method.
    }

    /**
     * @inheritDoc
     */
    public static function afterExpressionAnalysis(
        Expr $expr,
        Context $context,
        StatementsSource $statements_source,
        Codebase $codebase,
        array &$file_replacements = []
    ) {
        if ($expr instanceof Encapsed) {
            foreach ($expr->parts as $part) {
                if (!$part instanceof Variable) {
                    continue;
                }
                if (IssueBuffer::accepts(
                    new VariableInString(
                        'Do not put variables inside strings',
                        new CodeLocation($statements_source->getSource(), $expr)
                    ),
                    $statements_source->getSuppressedIssues()
                )) {
                    return null;
                }
            }
        }
        return null;
    }
}