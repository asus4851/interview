<?php

namespace app\controllers;

use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\imagine\BaseImage;
use Imagine\Image\Box;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView( $id )
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();

        if( $model->load(Yii::$app->request->post()) )
        {
            $model->date = date('Y-m-d');
            //Создаю уникальное имя картинки при сохранении используя дату вплоть до секунд
            $imageName = date('Y-m-d h:m:s');
            strval($imageName);
            $imageName = str_replace(' ', '-', $imageName);
            $imageName = str_replace(':', '-', $imageName);

            $model->photo = UploadedFile::getInstance($model, 'photo');
            $model->photo->saveAs('photo/' . $imageName . '.' . $model->photo->extension);

            $fullName = Yii::getAlias('@webroot') . '/photo/' . $imageName . '.' . $model->photo->extension;
            $img      = Image::getImagine()->open($fullName);

            $size  = $img->getSize();
            $ratio = $size->getWidth() / $size->getHeight();

            $width  = 200;
            $height = round($width / $ratio);

            $box = new Box($width, $height);
            $img->resize($box)->save(Yii::getAlias('@webroot') . '/thumb/' . $imageName . '.' . $model->photo->extension);
            $delete = getcwd() . '/photo/' . $imageName . '.'. $model->photo->extension;

            $model->photo = Yii::getAlias('@web') . '/thumb/' . $imageName . '.' . $model->photo->extension;
            if(!unlink($delete)){
                echo 'оригинал картинки не удалось удалить но если закоментировать эту проверку в контроллере то все будет работать только без удаления оригинала картинки';
                die;
            };
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel($id);

        if( $model->load(Yii::$app->request->post()) )
        {
            $model->date = date('Y-m-d');
            //Создаю уникальное имя картинки при сохранении используя дату вплоть до секунд
            $imageName = date('Y-m-d h:m:s');
            strval($imageName);
            $imageName = str_replace(' ', '-', $imageName);
            $imageName = str_replace(':', '-', $imageName);

            $model->photo = UploadedFile::getInstance($model, 'photo');
            $model->photo->saveAs('photo/' . $imageName . '.' . $model->photo->extension);

            $fullName = Yii::getAlias('@webroot') . '/photo/' . $imageName . '.' . $model->photo->extension;
            $img      = Image::getImagine()->open($fullName);

            $size  = $img->getSize();
            $ratio = $size->getWidth() / $size->getHeight();

            $width  = 200;
            $height = round($width / $ratio);

            $box = new Box($width, $height);
            $img->resize($box)->save(Yii::getAlias('@webroot') . '/thumb/' . $imageName . '.' . $model->photo->extension);
            $delete = getcwd() . '/photo/' . $imageName . '.'. $model->photo->extension;

            $model->photo = Yii::getAlias('@web') . '/thumb/' . $imageName . '.' . $model->photo->extension;
            if(!unlink($delete)){
                echo 'оригинал картинки не удалось удалить но если закоментировать эту проверку в контроллере то все будет работать только без удаления оригинала картинки';
                die;
            };
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete( $id )
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTree()
    {
        /**
         * @var Employee[] $items
         */
        $items = Employee::find()->all();

        $list = [];
        foreach( $items as $item )
        {
            if( empty($item->parent_id) )
            {
                if( isset($list[0]) === false )
                    $list[0] = [];
                $list[0][] = $item;
            } else
            {
                if( isset($list[$item->parent_id]) === false )
                    $list[$item->parent_id] = [];
                $list[$item->parent_id][] = $item;
            }
        }

        return $this->render('tree_view', [
            'list' => $list,
        ]);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id )
    {
        if( ($model = Employee::findOne($id)) !== null )
        {
            return $model;
        } else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
