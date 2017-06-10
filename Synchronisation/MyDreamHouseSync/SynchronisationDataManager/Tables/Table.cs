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
    public abstract class Table
    {
        protected enum DataType
        {
            STRING,
            DATE_FROM_MYSQL,
            BOOL_FROM_MYSQL,
            NUMERIC
        }
        protected string AddParam(string query, DataRow rowVal,int index, DataType dataType, bool isLast)
        {
            return AddParamPlain(query, rowVal[index], dataType, isLast);
        }

        protected string AddParamPlain(string query, object val, DataType dataType, bool isLast)
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
                    case DataType.DATE_FROM_MYSQL:
                        DateTime date = DateTime.ParseExact(val.ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                        query += "'" + String.Format("{0:yyyy-MM-dd HH:mm:ss}", date) + "'";
                        break;
                    case DataType.BOOL_FROM_MYSQL:
                        if ("True".Equals(val))
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
    }
}
