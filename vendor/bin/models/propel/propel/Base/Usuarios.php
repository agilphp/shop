<?php

namespace propel\propel\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use propel\propel\Tblfactura as ChildTblfactura;
use propel\propel\TblfacturaQuery as ChildTblfacturaQuery;
use propel\propel\Tblmenu as ChildTblmenu;
use propel\propel\TblmenuQuery as ChildTblmenuQuery;
use propel\propel\Tblrol as ChildTblrol;
use propel\propel\TblrolQuery as ChildTblrolQuery;
use propel\propel\Usuarios as ChildUsuarios;
use propel\propel\UsuariosQuery as ChildUsuariosQuery;
use propel\propel\Map\TblfacturaTableMap;
use propel\propel\Map\UsuariosTableMap;

/**
 * Base class that represents a row from the 'usuarios' table.
 *
 *
 *
 * @package    propel.generator.propel.propel.Base
 */
abstract class Usuarios implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\propel\\propel\\Map\\UsuariosTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id_usuario field.
     *
     * @var        string
     */
    protected $id_usuario;

    /**
     * The value for the nombre field.
     *
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the nivel field.
     *
     * @var        string
     */
    protected $nivel;

    /**
     * The value for the clave field.
     *
     * @var        string
     */
    protected $clave;

    /**
     * The value for the rolid field.
     *
     * @var        int
     */
    protected $rolid;

    /**
     * The value for the menuid field.
     *
     * @var        int
     */
    protected $menuid;

    /**
     * @var        ChildTblmenu
     */
    protected $aTblmenu;

    /**
     * @var        ChildTblrol
     */
    protected $aTblrol;

    /**
     * @var        ObjectCollection|ChildTblfactura[] Collection to store aggregation of ChildTblfactura objects.
     */
    protected $collTblfacturas;
    protected $collTblfacturasPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTblfactura[]
     */
    protected $tblfacturasScheduledForDeletion = null;

    /**
     * Initializes internal state of propel\propel\Base\Usuarios object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Usuarios</code> instance.  If
     * <code>obj</code> is an instance of <code>Usuarios</code>, delegates to
     * <code>equals(Usuarios)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Usuarios The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id_usuario] column value.
     *
     * @return string
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * Get the [nombre] column value.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [nivel] column value.
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Get the [clave] column value.
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Get the [rolid] column value.
     *
     * @return int
     */
    public function getRolid()
    {
        return $this->rolid;
    }

    /**
     * Get the [menuid] column value.
     *
     * @return int
     */
    public function getMenuid()
    {
        return $this->menuid;
    }

    /**
     * Set the value of [id_usuario] column.
     *
     * @param string $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setIdUsuario($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_usuario !== $v) {
            $this->id_usuario = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_ID_USUARIO] = true;
        }

        return $this;
    } // setIdUsuario()

    /**
     * Set the value of [nombre] column.
     *
     * @param string $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_NOMBRE] = true;
        }

        return $this;
    } // setNombre()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [nivel] column.
     *
     * @param string $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setNivel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nivel !== $v) {
            $this->nivel = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_NIVEL] = true;
        }

        return $this;
    } // setNivel()

    /**
     * Set the value of [clave] column.
     *
     * @param string $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setClave($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->clave !== $v) {
            $this->clave = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_CLAVE] = true;
        }

        return $this;
    } // setClave()

    /**
     * Set the value of [rolid] column.
     *
     * @param int $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setRolid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->rolid !== $v) {
            $this->rolid = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_ROLID] = true;
        }

        if ($this->aTblrol !== null && $this->aTblrol->getRolid() !== $v) {
            $this->aTblrol = null;
        }

        return $this;
    } // setRolid()

    /**
     * Set the value of [menuid] column.
     *
     * @param int $v new value
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function setMenuid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->menuid !== $v) {
            $this->menuid = $v;
            $this->modifiedColumns[UsuariosTableMap::COL_MENUID] = true;
        }

        if ($this->aTblmenu !== null && $this->aTblmenu->getMenuid() !== $v) {
            $this->aTblmenu = null;
        }

        return $this;
    } // setMenuid()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsuariosTableMap::translateFieldName('IdUsuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_usuario = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsuariosTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsuariosTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsuariosTableMap::translateFieldName('Nivel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nivel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsuariosTableMap::translateFieldName('Clave', TableMap::TYPE_PHPNAME, $indexType)];
            $this->clave = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsuariosTableMap::translateFieldName('Rolid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->rolid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UsuariosTableMap::translateFieldName('Menuid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->menuid = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UsuariosTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\propel\\propel\\Usuarios'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aTblrol !== null && $this->rolid !== $this->aTblrol->getRolid()) {
            $this->aTblrol = null;
        }
        if ($this->aTblmenu !== null && $this->menuid !== $this->aTblmenu->getMenuid()) {
            $this->aTblmenu = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UsuariosTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsuariosQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTblmenu = null;
            $this->aTblrol = null;
            $this->collTblfacturas = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Usuarios::setDeleted()
     * @see Usuarios::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuariosTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsuariosQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuariosTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UsuariosTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTblmenu !== null) {
                if ($this->aTblmenu->isModified() || $this->aTblmenu->isNew()) {
                    $affectedRows += $this->aTblmenu->save($con);
                }
                $this->setTblmenu($this->aTblmenu);
            }

            if ($this->aTblrol !== null) {
                if ($this->aTblrol->isModified() || $this->aTblrol->isNew()) {
                    $affectedRows += $this->aTblrol->save($con);
                }
                $this->setTblrol($this->aTblrol);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->tblfacturasScheduledForDeletion !== null) {
                if (!$this->tblfacturasScheduledForDeletion->isEmpty()) {
                    foreach ($this->tblfacturasScheduledForDeletion as $tblfactura) {
                        // need to save related object because we set the relation to null
                        $tblfactura->save($con);
                    }
                    $this->tblfacturasScheduledForDeletion = null;
                }
            }

            if ($this->collTblfacturas !== null) {
                foreach ($this->collTblfacturas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[UsuariosTableMap::COL_ID_USUARIO] = true;
        if (null !== $this->id_usuario) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UsuariosTableMap::COL_ID_USUARIO . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsuariosTableMap::COL_ID_USUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'id_usuario';
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'nombre';
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_NIVEL)) {
            $modifiedColumns[':p' . $index++]  = 'nivel';
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_CLAVE)) {
            $modifiedColumns[':p' . $index++]  = 'clave';
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_ROLID)) {
            $modifiedColumns[':p' . $index++]  = 'rolId';
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_MENUID)) {
            $modifiedColumns[':p' . $index++]  = 'menuId';
        }

        $sql = sprintf(
            'INSERT INTO usuarios (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_usuario':
                        $stmt->bindValue($identifier, $this->id_usuario, PDO::PARAM_INT);
                        break;
                    case 'nombre':
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'nivel':
                        $stmt->bindValue($identifier, $this->nivel, PDO::PARAM_STR);
                        break;
                    case 'clave':
                        $stmt->bindValue($identifier, $this->clave, PDO::PARAM_STR);
                        break;
                    case 'rolId':
                        $stmt->bindValue($identifier, $this->rolid, PDO::PARAM_INT);
                        break;
                    case 'menuId':
                        $stmt->bindValue($identifier, $this->menuid, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdUsuario($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsuariosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdUsuario();
                break;
            case 1:
                return $this->getNombre();
                break;
            case 2:
                return $this->getEmail();
                break;
            case 3:
                return $this->getNivel();
                break;
            case 4:
                return $this->getClave();
                break;
            case 5:
                return $this->getRolid();
                break;
            case 6:
                return $this->getMenuid();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Usuarios'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Usuarios'][$this->hashCode()] = true;
        $keys = UsuariosTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdUsuario(),
            $keys[1] => $this->getNombre(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getNivel(),
            $keys[4] => $this->getClave(),
            $keys[5] => $this->getRolid(),
            $keys[6] => $this->getMenuid(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTblmenu) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tblmenu';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'tblmenu';
                        break;
                    default:
                        $key = 'Tblmenu';
                }

                $result[$key] = $this->aTblmenu->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTblrol) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tblrol';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'tblrol';
                        break;
                    default:
                        $key = 'Tblrol';
                }

                $result[$key] = $this->aTblrol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTblfacturas) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tblfacturas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'tblfacturas';
                        break;
                    default:
                        $key = 'Tblfacturas';
                }

                $result[$key] = $this->collTblfacturas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\propel\propel\Usuarios
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsuariosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\propel\propel\Usuarios
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdUsuario($value);
                break;
            case 1:
                $this->setNombre($value);
                break;
            case 2:
                $this->setEmail($value);
                break;
            case 3:
                $this->setNivel($value);
                break;
            case 4:
                $this->setClave($value);
                break;
            case 5:
                $this->setRolid($value);
                break;
            case 6:
                $this->setMenuid($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UsuariosTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdUsuario($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNombre($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNivel($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setClave($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setRolid($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMenuid($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\propel\propel\Usuarios The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UsuariosTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsuariosTableMap::COL_ID_USUARIO)) {
            $criteria->add(UsuariosTableMap::COL_ID_USUARIO, $this->id_usuario);
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_NOMBRE)) {
            $criteria->add(UsuariosTableMap::COL_NOMBRE, $this->nombre);
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_EMAIL)) {
            $criteria->add(UsuariosTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_NIVEL)) {
            $criteria->add(UsuariosTableMap::COL_NIVEL, $this->nivel);
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_CLAVE)) {
            $criteria->add(UsuariosTableMap::COL_CLAVE, $this->clave);
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_ROLID)) {
            $criteria->add(UsuariosTableMap::COL_ROLID, $this->rolid);
        }
        if ($this->isColumnModified(UsuariosTableMap::COL_MENUID)) {
            $criteria->add(UsuariosTableMap::COL_MENUID, $this->menuid);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildUsuariosQuery::create();
        $criteria->add(UsuariosTableMap::COL_ID_USUARIO, $this->id_usuario);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdUsuario();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getIdUsuario();
    }

    /**
     * Generic method to set the primary key (id_usuario column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdUsuario($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdUsuario();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \propel\propel\Usuarios (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNombre($this->getNombre());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setNivel($this->getNivel());
        $copyObj->setClave($this->getClave());
        $copyObj->setRolid($this->getRolid());
        $copyObj->setMenuid($this->getMenuid());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTblfacturas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTblfactura($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdUsuario(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \propel\propel\Usuarios Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildTblmenu object.
     *
     * @param  ChildTblmenu $v
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTblmenu(ChildTblmenu $v = null)
    {
        if ($v === null) {
            $this->setMenuid(NULL);
        } else {
            $this->setMenuid($v->getMenuid());
        }

        $this->aTblmenu = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTblmenu object, it will not be re-added.
        if ($v !== null) {
            $v->addUsuarios($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTblmenu object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTblmenu The associated ChildTblmenu object.
     * @throws PropelException
     */
    public function getTblmenu(ConnectionInterface $con = null)
    {
        if ($this->aTblmenu === null && ($this->menuid != 0)) {
            $this->aTblmenu = ChildTblmenuQuery::create()->findPk($this->menuid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTblmenu->addUsuarioss($this);
             */
        }

        return $this->aTblmenu;
    }

    /**
     * Declares an association between this object and a ChildTblrol object.
     *
     * @param  ChildTblrol $v
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTblrol(ChildTblrol $v = null)
    {
        if ($v === null) {
            $this->setRolid(NULL);
        } else {
            $this->setRolid($v->getRolid());
        }

        $this->aTblrol = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTblrol object, it will not be re-added.
        if ($v !== null) {
            $v->addUsuarios($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTblrol object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTblrol The associated ChildTblrol object.
     * @throws PropelException
     */
    public function getTblrol(ConnectionInterface $con = null)
    {
        if ($this->aTblrol === null && ($this->rolid != 0)) {
            $this->aTblrol = ChildTblrolQuery::create()->findPk($this->rolid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTblrol->addUsuarioss($this);
             */
        }

        return $this->aTblrol;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Tblfactura' == $relationName) {
            $this->initTblfacturas();
            return;
        }
    }

    /**
     * Clears out the collTblfacturas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTblfacturas()
     */
    public function clearTblfacturas()
    {
        $this->collTblfacturas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTblfacturas collection loaded partially.
     */
    public function resetPartialTblfacturas($v = true)
    {
        $this->collTblfacturasPartial = $v;
    }

    /**
     * Initializes the collTblfacturas collection.
     *
     * By default this just sets the collTblfacturas collection to an empty array (like clearcollTblfacturas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTblfacturas($overrideExisting = true)
    {
        if (null !== $this->collTblfacturas && !$overrideExisting) {
            return;
        }

        $collectionClassName = TblfacturaTableMap::getTableMap()->getCollectionClassName();

        $this->collTblfacturas = new $collectionClassName;
        $this->collTblfacturas->setModel('\propel\propel\Tblfactura');
    }

    /**
     * Gets an array of ChildTblfactura objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuarios is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTblfactura[] List of ChildTblfactura objects
     * @throws PropelException
     */
    public function getTblfacturas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTblfacturasPartial && !$this->isNew();
        if (null === $this->collTblfacturas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTblfacturas) {
                // return empty collection
                $this->initTblfacturas();
            } else {
                $collTblfacturas = ChildTblfacturaQuery::create(null, $criteria)
                    ->filterByUsuarios($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTblfacturasPartial && count($collTblfacturas)) {
                        $this->initTblfacturas(false);

                        foreach ($collTblfacturas as $obj) {
                            if (false == $this->collTblfacturas->contains($obj)) {
                                $this->collTblfacturas->append($obj);
                            }
                        }

                        $this->collTblfacturasPartial = true;
                    }

                    return $collTblfacturas;
                }

                if ($partial && $this->collTblfacturas) {
                    foreach ($this->collTblfacturas as $obj) {
                        if ($obj->isNew()) {
                            $collTblfacturas[] = $obj;
                        }
                    }
                }

                $this->collTblfacturas = $collTblfacturas;
                $this->collTblfacturasPartial = false;
            }
        }

        return $this->collTblfacturas;
    }

    /**
     * Sets a collection of ChildTblfactura objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tblfacturas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuarios The current object (for fluent API support)
     */
    public function setTblfacturas(Collection $tblfacturas, ConnectionInterface $con = null)
    {
        /** @var ChildTblfactura[] $tblfacturasToDelete */
        $tblfacturasToDelete = $this->getTblfacturas(new Criteria(), $con)->diff($tblfacturas);


        $this->tblfacturasScheduledForDeletion = $tblfacturasToDelete;

        foreach ($tblfacturasToDelete as $tblfacturaRemoved) {
            $tblfacturaRemoved->setUsuarios(null);
        }

        $this->collTblfacturas = null;
        foreach ($tblfacturas as $tblfactura) {
            $this->addTblfactura($tblfactura);
        }

        $this->collTblfacturas = $tblfacturas;
        $this->collTblfacturasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Tblfactura objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Tblfactura objects.
     * @throws PropelException
     */
    public function countTblfacturas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTblfacturasPartial && !$this->isNew();
        if (null === $this->collTblfacturas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTblfacturas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTblfacturas());
            }

            $query = ChildTblfacturaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuarios($this)
                ->count($con);
        }

        return count($this->collTblfacturas);
    }

    /**
     * Method called to associate a ChildTblfactura object to this object
     * through the ChildTblfactura foreign key attribute.
     *
     * @param  ChildTblfactura $l ChildTblfactura
     * @return $this|\propel\propel\Usuarios The current object (for fluent API support)
     */
    public function addTblfactura(ChildTblfactura $l)
    {
        if ($this->collTblfacturas === null) {
            $this->initTblfacturas();
            $this->collTblfacturasPartial = true;
        }

        if (!$this->collTblfacturas->contains($l)) {
            $this->doAddTblfactura($l);

            if ($this->tblfacturasScheduledForDeletion and $this->tblfacturasScheduledForDeletion->contains($l)) {
                $this->tblfacturasScheduledForDeletion->remove($this->tblfacturasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTblfactura $tblfactura The ChildTblfactura object to add.
     */
    protected function doAddTblfactura(ChildTblfactura $tblfactura)
    {
        $this->collTblfacturas[]= $tblfactura;
        $tblfactura->setUsuarios($this);
    }

    /**
     * @param  ChildTblfactura $tblfactura The ChildTblfactura object to remove.
     * @return $this|ChildUsuarios The current object (for fluent API support)
     */
    public function removeTblfactura(ChildTblfactura $tblfactura)
    {
        if ($this->getTblfacturas()->contains($tblfactura)) {
            $pos = $this->collTblfacturas->search($tblfactura);
            $this->collTblfacturas->remove($pos);
            if (null === $this->tblfacturasScheduledForDeletion) {
                $this->tblfacturasScheduledForDeletion = clone $this->collTblfacturas;
                $this->tblfacturasScheduledForDeletion->clear();
            }
            $this->tblfacturasScheduledForDeletion[]= $tblfactura;
            $tblfactura->setUsuarios(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuarios is new, it will return
     * an empty collection; or if this Usuarios has previously
     * been saved, it will retrieve related Tblfacturas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuarios.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTblfactura[] List of ChildTblfactura objects
     */
    public function getTblfacturasJoinTblcliente(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTblfacturaQuery::create(null, $criteria);
        $query->joinWith('Tblcliente', $joinBehavior);

        return $this->getTblfacturas($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuarios is new, it will return
     * an empty collection; or if this Usuarios has previously
     * been saved, it will retrieve related Tblfacturas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuarios.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTblfactura[] List of ChildTblfactura objects
     */
    public function getTblfacturasJoinTblmetodopago(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTblfacturaQuery::create(null, $criteria);
        $query->joinWith('Tblmetodopago', $joinBehavior);

        return $this->getTblfacturas($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTblmenu) {
            $this->aTblmenu->removeUsuarios($this);
        }
        if (null !== $this->aTblrol) {
            $this->aTblrol->removeUsuarios($this);
        }
        $this->id_usuario = null;
        $this->nombre = null;
        $this->email = null;
        $this->nivel = null;
        $this->clave = null;
        $this->rolid = null;
        $this->menuid = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTblfacturas) {
                foreach ($this->collTblfacturas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTblfacturas = null;
        $this->aTblmenu = null;
        $this->aTblrol = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsuariosTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
