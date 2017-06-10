using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class Ebook : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into ebook (ebook_id,titel,autor,erscheinungsdatum,auflage,bild,content,mimetype,filesize,active) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            if(type == DatabaseType.DB2)
            {
                query = AddParam(query, row, 3, DataType.DATE_FROM_MYSQL, false);
            }else
            {
                query = AddParam(query, row, 3, DataType.DATE_FROM_MYSQL, false);
            }
            query = AddParam(query, row, 4, DataType.STRING, false);
            query = AddParam(query, row, 5, DataType.STRING, false);
            query = AddParam(query, row, 6, DataType.STRING, false);
            query = AddParam(query, row, 7, DataType.STRING, false);
            query = AddParam(query, row, 8, DataType.NUMERIC, false);
            query = AddParam(query, row, 9, DataType.BOOL_FROM_MYSQL, true);

            return query;
        }
    }
}
