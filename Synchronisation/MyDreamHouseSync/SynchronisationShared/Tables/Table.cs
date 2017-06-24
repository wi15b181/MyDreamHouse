using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Data;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public abstract class Table : SyncData
    {
        public enum DataType
        {
            STRING,
            DATE_FROM_MYSQL,
            DATE_FROM_DB2,
            BOOL_FROM_MYSQL,
            DATETIME,
            NUMERIC
        }
        protected string AddParam(string query, DataRow rowVal,int index, DataType dataType, bool isLast)
        {
            return AddParamPlain(query, rowVal[index], dataType, isLast);
        }

        public string AddParamPlain(string query, object val, DataType dataType, bool isLast)
        {
            if(String.IsNullOrWhiteSpace(""+val))
            {
                query += "null";
            }else
            {
                switch (dataType)
                {
                    case DataType.STRING:
                        query += "'";
                        query += val;
                        query += "'";
                        break;
                    case DataType.DATETIME:
                        DateTime DATE_TIME = DateTime.ParseExact(val.ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                        query += "'" + String.Format("{0:yyyy-MM-dd HH:mm:ss.fff}", DATE_TIME) + "'";
                        break;
                    case DataType.DATE_FROM_MYSQL:
                        DateTime DATE_FROM_MYSQL = DateTime.ParseExact(val.ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                        query += "'" + String.Format("{0:yyyy-MM-dd HH:mm:ss}", DATE_FROM_MYSQL) + "'";
                        break;
                    case DataType.DATE_FROM_DB2:
                        DateTime DATE_FROM_DB2 = DateTime.ParseExact(val.ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                        query += "'" + String.Format("{0:yyyy-MM-dd HH:mm}", DATE_FROM_DB2) + "'";
                        break;
                    case DataType.BOOL_FROM_MYSQL:
                        if ("True".Equals(val) || 1.Equals(val))
                        {
                            query += "'Y'";
                        }
                        else
                        {
                            query += "'N'";
                        }
                        break;
                    case DataType.NUMERIC:
                        query += (""+val).Replace(",",".");
                        break;
                    default:
                        query += val;
                        break;
                }
            }

            query += isLast ? ")" : ",";

            return query;
        }
        public abstract string GetInsertString(DataRow row, DatabaseType type);
        public abstract string GetTableName();
        public abstract string GetPrimaryKeyColumn();
        public string GetSelectAllString()
        {
            return "select * from " + GetTableName();
        }

        public string getDeleteString(int pk)
        {
            return "delete from " + GetTableName() + " where "+GetPrimaryKeyColumn()+" = " + pk;
        }

        public string GetUpdateString()
        {
            return "update " + GetTableName() + " set ";
        }
        public string GetWherePk(int pk)
        {
            return GetPrimaryKeyColumn()+" = "+pk;
        }

        public static string AddUpdateParam(string query, string column, object val,DatabaseType databaseType, DataType dataType, bool isLast)
        {

            if (column.Equals("size") && databaseType.Equals(DatabaseType.DB2))
            {
                column = "filesize"; //custom behaviour for DB2
            }

            string extension = column + " = " ;


            if (String.IsNullOrEmpty(val.ToString()))
            {
                extension += "null"; ;
                extension = isLast ? extension : extension + ", ";
                return query + extension;
            }

            switch (dataType)
            {
                case DataType.STRING:
                    extension += "'";
                    extension += val;
                    extension += "'";
                    break;
                case DataType.DATETIME:
                    if (databaseType.Equals(DatabaseType.DB2))
                    {
                        goto case DataType.DATE_FROM_MYSQL;
                    }
                    else
                    {
                        goto case DataType.DATE_FROM_DB2;
                    }
                case DataType.DATE_FROM_MYSQL:
                    DateTime DATE_FROM_MYSQL = DateTime.ParseExact(val.ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                    extension += "'" + String.Format("{0:yyyy-MM-dd HH:mm:ss}", DATE_FROM_MYSQL) + "'";
                    break;
                case DataType.DATE_FROM_DB2:
                    DateTime DATE_FROM_DB2 = DateTime.ParseExact(val.ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                    extension += "'" + String.Format("{0:yyyy-MM-dd HH:mm:ss}", DATE_FROM_DB2) + "'";
                    break;
                case DataType.BOOL_FROM_MYSQL:
                    if ("True".Equals(val) || 1.Equals(val))
                    {
                        extension += "'Y'";
                    } else
                    {
                        extension += "'N'";
                    }
                    break;
                case DataType.NUMERIC:
                    extension += ("" + val).Replace(",", ".");
                    break;
                default:
                    extension += val;
                    break;
            }

            extension = isLast ? extension : extension + ", ";
            return query+extension;
        }
    }
}
