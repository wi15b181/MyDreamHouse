using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Ebook : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string fsColumn = "size";
            if (type.Equals(DatabaseType.DB2))
            {
                fsColumn = "filesize"; //custom behaviour for DB2
            }

            string query = "insert into " + GetTableName() + " (ebook_id,titel,autor,erscheinungsdatum,auflage,bild,content,mimetype,"+fsColumn+",active) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            if(type == DatabaseType.DB2)
            {
                query = AddParam(query, row, 3, DataType.DATE_FROM_MYSQL, false);
            }else
            {
                query = AddParam(query, row, 3, DataType.DATE_FROM_DB2, false);
            }
            query = AddParam(query, row, 4, DataType.STRING, false);
            query = AddParam(query, row, 5, DataType.STRING, false);
            query = AddParam(query, row, 6, DataType.STRING, false);
            query = AddParam(query, row, 7, DataType.STRING, false);
            query = AddParam(query, row, 8, DataType.NUMERIC, false);
            query = AddParam(query, row, 9, DataType.BOOL_FROM_MYSQL, true);

            return query;
        }

        public override string GetPrimaryKeyColumn()
        {
            return "ebook_id";
        }

        public override string GetTableName()
        {
            return "ebook";
        }
    }
}
