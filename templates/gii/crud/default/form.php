<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$formModelClass = StringHelper::basename($generator->formModelClass);
if ($modelClass === $formModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->formModelClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;

/**
 * <?= $formModelClass ?> represents the form for the model `<?= $generator->modelClass ?>`.
 */
class <?= $formModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        return parent::save($runValidation, $attributeNames);
    }

}